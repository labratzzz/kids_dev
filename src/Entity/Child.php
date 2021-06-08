<?php


namespace App\Entity;

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
     * @var Child
     * @ORM\OneToMany(targetEntity="App\Entity\ChildAnswer", mappedBy="child")
     * @ORM\Id()
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $answers;
}