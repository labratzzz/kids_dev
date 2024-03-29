<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class EducatorRepository extends EntityRepository
{
    /**
     * Returns Doctrine QueryBuilder with all educators with descending createdAt.
     *
     * @return QueryBuilder
     */
    public function getAllQueryBuilder()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->orderBy('e.createdAt', 'DESC');

        return $qb;
    }
}