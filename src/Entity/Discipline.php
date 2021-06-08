<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents discipline.
 *
 * Class Discipline
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="disciplines")
 */
class Discipline
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
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Groups({"Main"})
     */
    private $image;

    /**
     * @var Test[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Test", mappedBy="discipline")
     */
    private $tests;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Test[]|ArrayCollection
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * @param Test[]|ArrayCollection $tests
     */
    public function setTests($tests)
    {
        $this->tests = $tests;
    }

}