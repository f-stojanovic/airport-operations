<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use LogicException;
use Symfony\Bridge\Doctrine\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected static $entity;

    public function __construct(ManagerRegistry $registry)
    {
        if (null === static::$entity) {
            throw new LogicException('Repository should define `self::$entity` property as FQCN of entity class');
        }

        parent::__construct($registry, static::$entity);
    }

    public function findOrFail(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $entities = $this->findBy($criteria, $orderBy, $limit, $offset);

        if ([] === $entities) {
            throw new EntityNotFoundException();
        }

        return $entities;
    }

    public function findOneOrFail(array $criteria, array $orderBy = null)
    {
        $entity = $this->findOneBy($criteria, $orderBy);

        if (null === $entity) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }
}
