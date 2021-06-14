<?php


namespace App\Repository;


use App\Entity\Question;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class AnswerRepository extends EntityRepository
{
    /**
     * Returns Doctrine QueryBuilder with answers to given Question.
     *
     * @param Question $question
     * @return QueryBuilder
     */
    public function getByQuestionQueryBuilder(Question $question)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->innerJoin(Question::class, 'q', Join::WITH, 'q.id = a.question')
            ->where('a.question = :question')
            ->setParameter('question', $question);

        return $qb;
    }
}