<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents an answer by child.
 *
 * Class ChildAnswer
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="child_answers")
 */
class ChildAnswer
{
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @var Child
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Child", inversedBy="agreementUsers")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Groups({"Main"})
     */
    private $child;

    /**
     * @var Answer
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Answer")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Groups({"Main"})
     */
    private $answer;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetimetz")
     * @Groups({"Main"})
     */
    private $createdAt;

    /**
     * @return Child
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * @param Child $child
     */
    public function setChild($child)
    {
        $this->child = $child;
    }

    /**
     * @return Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param Answer $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

}