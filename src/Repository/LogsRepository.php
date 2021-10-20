<?php

namespace App\Repository;

use App\Entity\Logs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LogsRepository|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogsRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogsRepository[]    findAll()
 * @method LogsRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logs::class);
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getLogsListPaginated(int $page = 1, int $pageSize = 20): array
    {
        $query = $this->createQueryBuilder('l')
            ->select('l')
            ->orderBy('l.timeOfChange', 'DESC')
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
     */
    public function getLogsForDashboard()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.timeOfChange', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
