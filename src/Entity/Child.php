<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     */
    private $answers;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetimetz")
     * @Groups({"Main"})
     */
    private $birthday;

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

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }
}