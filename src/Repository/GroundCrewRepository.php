<?php

namespace App\Repository;

use App\Entity\GroundCrew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroundCrewRepository|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroundCrewRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroundCrewRepository[]    findAll()
 * @method GroundCrewRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroundCrewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroundCrew::class);
    }

    public function getMainGroundCrew(): ?GroundCrew
    {
        return $this->findOneBy(['id' => 1]);
    }
}
