<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class DisciplineRepository extends EntityRepository
{
    /**
     * Returns Doctrine QueryBuilder with all disciplines.
     *
     * @return QueryBuilder
     */
    public function getAllQueryBuilder()
    {
       return $this->createQueryBuilder('d');
    }
}