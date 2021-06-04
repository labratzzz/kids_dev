<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents doctor's post (vacation).
 *
 * Class DoctorType
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="tests")
 */
class Test
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups({"Main"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Groups({"Main"})
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"Main"})
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Groups({"Main"})
     */
    private $image;

    /**
     * @var Question[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="")
     */
    private $questions;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Question[]|ArrayCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param Question[]|ArrayCollection $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }
}