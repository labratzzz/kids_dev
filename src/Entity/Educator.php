<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents educator.
 *
 * Class Educator
 * @package App\Entity
 *
 * @ORM\Entity()
 */
class Educator extends User
{
    /**
     * @var int
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"Main"})
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^\d{10}$/")
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;
}