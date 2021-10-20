<?php

namespace App\Controller;

use App\Repository\LogsRepository;
use App\Service\MenuBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LogsController.
 */
class LogsController extends AbstractController
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
     * @var LogsRepository
     */
    private $logsRepository;

    /**
     * AircraftController constructor.
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        MenuBuilder $builder,
        LogsRepository $logsRepository
    ) {
        $this->entityManager = $entityManager;
        $this->builder = $builder;
        $this->logsRepository = $logsRepository;
    }

    /**
     * @Route("/logs", name="logs")
     */
    public function getLogsAction(Request $request): Response
    {
        $page = intval($request->get('page'));
        if ($page < 1) {
            $page = 1;
        }

        $logs = $this->logsRepository->getLogsListPaginated();

        $menu = $this->builder->getMenuData();

        return $this->render('log.html.twig', [
            'menu' => $menu,
            'logs' => $logs['data'],
            'contentTitle' => 'List of Logs',
            'totalItems' => $logs['totalItems'],
            'totalPages' => $logs['pagesCount'],
            'pageSize' => 20,
            'currentPage' => $page,
        ]);
    }
}
