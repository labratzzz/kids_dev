<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents educator.
 *
 * Class EducatorCreateType
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\EducatorRepository")
 */
class Educator extends User
{

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var Test[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Test", mappedBy="creator")
     */
    private $tests;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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