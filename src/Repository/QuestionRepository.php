<?php


namespace App\Repository;


use App\Entity\Test;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class QuestionRepository extends EntityRepository
{
    /**
     * Returns Doctrine QueryBuilder with all questions of given test.
     *
     * @param Test $test
     * @return QueryBuilder
     */
    public function getByTestQueryBuilder(Test $test)
    {
        $qb = $this->createQueryBuilder('q');
        $qb->innerJoin(Test::class, 't', Join::WITH, 't.id = q.test')
            ->where('q.test = :test')
            ->setParameter('test', $test);

        return $qb;
    }
}