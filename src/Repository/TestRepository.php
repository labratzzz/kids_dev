<?php


namespace App\Repository;


use App\Entity\Discipline;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class TestRepository extends EntityRepository
{
    /**
     * Returns Doctrine QueryBuilder with all tests.
     *
     * @return QueryBuilder
     */
    public function getAllQueryBuilder()
    {
        return $this->createQueryBuilder('t');;
    }

    /**
     * Returns Doctrine QueryBuilder with all tests of given Discipline.
     *
     * @param Discipline $discipline
     * @return QueryBuilder
     */
    public function getByDisciplineQueryBuilder(Discipline $discipline)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->innerJoin(Discipline::class, 'd', Join::WITH, 'd.id = t.discipline')
            ->where('t.discipline = :discipline')
            ->setParameter('discipline', $discipline);

        return $qb;
    }
}