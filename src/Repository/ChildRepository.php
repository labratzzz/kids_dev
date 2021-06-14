<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class ChildRepository extends EntityRepository
{
    /**
     * Returns Doctrine QueryBuilder with all children with descending createdAt.
     *
     * @return QueryBuilder
     */
    public function getAllQueryBuilder()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->orderBy('c.createdAt', 'DESC');

        return $qb;
    }
}