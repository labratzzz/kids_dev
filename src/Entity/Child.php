<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents child.
 *
 * Class Child
 * @package App\Entity
 *
 * @ORM\Entity()
 */
class Child extends User
{
    /**
     * @var ChildAnswer[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\ChildAnswer", mappedBy="child")
     * @ORM\Id()
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $answers;

    /**
     * @return ChildAnswer[]|ArrayCollection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param ChildAnswer[]|ArrayCollection $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }
}