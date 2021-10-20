<?php

namespace App\Controller;

use App\Entity\Aircraft;
use App\Entity\Logs;
use App\Repository\AircraftRepository;
use App\Repository\GroundCrewRepository;
use App\Service\AircraftService;
use App\Service\LogsService;
use App\Service\MenuBuilder;
use App\Service\WeatherApiService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class AircraftController.
 */
class AircraftController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var MenuBuilder
     */
    private $builder;

    /**
     * @var AircraftRepository
     */
    private $aircraftRepository;

    /**
     * @var GroundCrewRepository
     */
    private $groundCrewRepository;

    /**
     * @var LogsService
     */
    private $logsService;

    /**
     * @var AircraftService
     */
    private $aircraftService;

    /**
     * @var WeatherApiService
     */
    private $weatherApiService;

    /**
     * AircraftController constructor.
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        MenuBuilder $builder,
        AircraftRepository $aircraftRepository,
        LogsService $logsService,
        GroundCrewRepository $groundCrewRepository,
        AircraftService $aircraftService,
        WeatherApiService $weatherApiService
    ) {
        $this->entityManager = $entityManager;
        $this->builder = $builder;
        $this->aircraftRepository = $aircraftRepository;
        $this->groundCrewRepository = $groundCrewRepository;
        $this->logsService = $logsService;
        $this->aircraftService = $aircraftService;
        $this->weatherApiService = $weatherApiService;
    }

    /**
     * @Route("/aircraft", name="aircraft")
     */
    public function getAircraftAction(Request $request): Response
    {
        $page = intval($request->get('page'));
        if ($page < 1) {
            $page = 1;
        }

        $aircraft = $this->aircraftRepository->getAircraftListPaginated($page);

        $menu = $this->builder->getMenuData();

        return $this->render('aircraft.html.twig', [
            'menu' => $menu,
            'aircraftList' => $aircraft['data'],
            'contentTitle' => 'Aircraft List',
            'totalItems' => $aircraft['totalItems'],
            'totalPages' => $aircraft['pagesCount'],
            'pageSize' => 20,
            'currentPage' => $page,
        ]);
    }

    /**
     * @Route("/aircraft/{id}", name="aircraft_communication")
     */
    public function aircraftCommunicationAction(Aircraft $aircraft): Response
    {
        $menu = $this->builder->getMenuData();

        return $this->render('aircraft-communication.html.twig', [
            'menu' => $menu,
            'aircraft' => $aircraft,
            'contentTitle' => "Aircraft {$aircraft->getCallSign()} Communication Center",
        ]);
    }

    /**
     * @Route("/aircraft/{id}/take-off", name="aircraft_take_off")
     *
     * @throws Exception
     */
    public function aircraftTakeOffAction(Aircraft $aircraft): Response
    {
        $menu = $this->builder->getMenuData();
        $groundCrew = $this->groundCrewRepository->getMainGroundCrew();

        if (!is_null($this->aircraftRepository->landedCheckCount())) {
            $aircraft->setPosition(Aircraft::POSITION_AIRBORNE);
            $this->entityManager->persist($aircraft);
            $this->entityManager->flush();

            $state = Logs::STATE_ACCEPTED;
            $this->addFlash('success', 'Aircraft take-off granted! Aircraft is now airborne.');
        } else {
            $state = Logs::STATE_REJECTED;
            $this->addFlash('danger', 'Aircraft take-off not permitted! Another aircraft is landed and its currently on the runway.');
        }

        $this->logsService->setLogInfo(
            $aircraft->getName(),
            $aircraft,
            $groundCrew,
            $state,
            $aircraft->getPosition()
        );

        return $this->render('aircraft-communication.html.twig', [
            'menu' => $menu,
            'aircraft' => $aircraft,
            'contentTitle' => "Aircraft {$aircraft->getCallSign()} Communication Center",
        ]);
    }

    /**
     * @Route("/aircraft/{id}/landing", name="aircraft_landing")
     *
     * @throws Exception
     */
    public function aircraftLandingAction(Aircraft $aircraft): Response
    {
        $menu = $this->builder->getMenuData();
        $groundCrew = $this->groundCrewRepository->getMainGroundCrew();

        if (!is_null($this->aircraftService->getParkingSpotsCountInfo($aircraft->getType()))) {
            if (!is_null($this->aircraftRepository->onApproachCheckCount())) {
                $aircraft->setPosition(Aircraft::POSITION_APPROACH);
                $this->entityManager->persist($aircraft);
                $this->entityManager->flush();

                $state = Logs::STATE_ACCEPTED;
                $this->addFlash('success', 'Aircraft landing granted! Aircraft is now on approach.');
            } else {
                $state = Logs::STATE_REJECTED;
                $this->addFlash('danger', 'Aircraft landing not permitted! Another aircraft is on approach, taking-off or landed.');
            }
        } else {
            $state = Logs::STATE_REJECTED;
            $this->addFlash('danger', 'Aircraft landing not permitted! No parking spots are available for type.');
        }

        $this->logsService->setLogInfo(
            $aircraft->getName(),
            $aircraft,
            $groundCrew,
            $state,
            $aircraft->getPosition()
        );

        return $this->render('aircraft-communication.html.twig', [
            'menu' => $menu,
            'aircraft' => $aircraft,
            'contentTitle' => "Aircraft {$aircraft->getCallSign()} Communication Center",
        ]);
    }

    /**
     * @Route("/aircraft/{id}/cancel-landing", name="aircraft_cancel_landing")
     *
     * @throws Exception
     */
    public function aircraftCancelLandingAction(Aircraft $aircraft): Response
    {
        $menu = $this->builder->getMenuData();
        $groundCrew = $this->groundCrewRepository->getMainGroundCrew();

        $aircraft->setPosition(Aircraft::POSITION_AIRBORNE);
        $this->entityManager->persist($aircraft);
        $this->entityManager->flush();

        $this->logsService->setLogInfo(
            $aircraft->getName(),
            $aircraft,
            $groundCrew,
            Logs::STATE_ACCEPTED,
            $aircraft->getPosition()
        );

        $this->addFlash('success', 'Aircraft landing canceled! Aircraft is again airborne.');

        return $this->render('aircraft-communication.html.twig', [
            'menu' => $menu,
            'aircraft' => $aircraft,
            'contentTitle' => "Aircraft {$aircraft->getCallSign()} Communication Center",
        ]);
    }

    /**
     * @Route("/{callSign}/location", name="aircraft_location")
     *
     * @throws Exception
     */
    public function transmitCurrentPositionAction(Aircraft $aircraft, Request $request): Response
    {
        $menu = $this->builder->getMenuData();

        $form = $this->createFormBuilder($aircraft)
            ->add('type', TextType::class, ['disabled' => true, 'data' => $aircraft->getType(), 'label' => 'Type of Aircraft', 'attr' => ['class' => 'form-control']])
            ->add('latitude', TextType::class, ['label' => 'Latitude', 'attr' => ['class' => 'form-control']])
            ->add('longitude', TextType::class, ['label' => 'Longitude', 'attr' => ['class' => 'form-control']])
            ->add('altitude', IntegerType::class, ['label' => 'Altitude', 'attr' => ['class' => 'form-control']])
            ->add('heading', IntegerType::class, ['label' => 'Heading', 'attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Update', 'attr' => ['class' => 'btn btn-primary action-save']])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('aircraft');
        }

        return $this->render('aircraft-location.html.twig', [
            'form' => $form->createView(),
            'menu' => $menu,
            'aircraft' => $aircraft,
            'contentTitle' => "Aircraft {$aircraft->getCallSign()} Position Transmitter Center",
        ]);
    }

    /**
     * This is for triggering weather api manually via btn, but cron is also added.
     *
     * @Route("/{callSign}/weather", name="weather")
     *
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    public function requestWeatherAction(): Response
    {
        $this->weatherApiService->getWeatherInformation();
        return $this->redirectToRoute('dashboard');
    }
}
