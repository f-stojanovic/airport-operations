<?php

namespace App\Repository;

use App\Entity\Aircraft;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AircraftRepository|null find($id, $lockMode = null, $lockVersion = null)
 * @method AircraftRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method AircraftRepository[]    findAll()
 * @method AircraftRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AircraftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aircraft::class);
    }

    public function getAircraftListPaginated(int $page = 1, int $pageSize = 20): array
    {
        $query = $this->createQueryBuilder('a')
            ->select('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery();

        $paginator = new Paginator($query);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        $paginator->getQuery()->setFirstResult($pageSize * ($page - 1))->setMaxResults($pageSize);

        return [
            'data' => $paginator,
            'totalItems' => $totalItems,
            'pagesCount' => $pagesCount,
        ];
    }

    /**
     * @return int|mixed|string
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function airlinerParkedCount()
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.type = :type')
            ->andWhere('a.position = :position')
            ->setParameter('type', Aircraft::TYPE_AIRLINER)
            ->setParameter('position', Aircraft::POSITION_PARKED)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return int|mixed|string
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function privateParkedCount()
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.type = :type')
            ->andWhere('a.position = :position')
            ->setParameter('type', Aircraft::TYPE_PRIVATE)
            ->setParameter('position', Aircraft::POSITION_PARKED)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return int|mixed|string
     */
    public function getParkedAirliner()
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.type = :type')
            ->andWhere('a.position = :position')
            ->setParameter('type', Aircraft::TYPE_AIRLINER)
            ->setParameter('position', Aircraft::POSITION_PARKED)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int|mixed|string
     */
    public function getParkedPrivate()
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.type = :type')
            ->andWhere('a.position = :position')
            ->setParameter('type', Aircraft::TYPE_PRIVATE)
            ->setParameter('position', Aircraft::POSITION_PARKED)
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function onApproachCheckCount()
    {
        $result = $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.position = :positionApproach')
            ->orWhere('a.position = :positionTakeOff')
            ->orWhere('a.position = :positionLanded')
            ->setParameter('positionApproach', Aircraft::POSITION_APPROACH)
            ->setParameter('positionTakeOff', Aircraft::POSITION_TAKE_OFF)
            ->setParameter('positionLanded', Aircraft::POSITION_LANDED)
            ->getQuery()
            ->getSingleScalarResult();

        if ($result >= 1) {
            return null;
        }

        return $result;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function landedCheckCount()
    {
        $result = $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->andWhere('a.position = :position')
            ->setParameter('position', Aircraft::POSITION_LANDED)
            ->getQuery()
            ->getSingleScalarResult();

        if ($result >= 1) {
            return null;
        }

        return $result;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function onApproachCheck()
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->andWhere('a.position = :position')
            ->setParameter('position', Aircraft::POSITION_APPROACH)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function landedCheck()
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->andWhere('a.position = :position')
            ->setParameter('position', Aircraft::POSITION_LANDED)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getParkingSpotCount($type, $airlinerParkingSpotNumber, $privateParkingSpotNumber)
    {
        $result = $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.type = :type')
            ->andWhere('a.position = :position')
            ->setParameter('type', $type)
            ->setParameter('position', Aircraft::POSITION_PARKED)
            ->getQuery()
            ->getSingleScalarResult();

        if (Aircraft::TYPE_AIRLINER === $type) {
            if ($result >= intval($airlinerParkingSpotNumber)) {
                return null;
            } else {
                return $result;
            }
        }

        if (Aircraft::TYPE_PRIVATE === $type) {
            if ($result >= intval($privateParkingSpotNumber)) {
                return null;
            }
        } else {
            return $result;
        }
    }
}
