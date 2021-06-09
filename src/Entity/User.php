<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents user.
 *
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"child"="App\Entity\Child", "educator"="App\Entity\Educator"})
 * @UniqueEntity(fields={"username"}, message="Пользователь с таким логином уже зарегистрирован.")
 * @ORM\Table(name="users")
 */
abstract class User implements AdvancedUserInterface
{
    const DEFAULT_PASSWORD = 'default_password';

    const SEX_CHOICES = [
        'Мужчина' => 0,
        'Женщина' => 1
    ];
    const ROLE_DEFAULT = 'ROLE_USER';

    public function __construct()
    {
        $this->enabled = true;
        $this->createdAt = new \DateTime();
    }

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @ORM\Id()
     * @Groups({"Main"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\NotBlank()
     */
    private $surname;

    /**
     * @var string|null
     */
    private $plainPassword;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string[]
     * @ORM\Column(type="array")
     * @Groups({"Main"})
     */
    private $roles;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Groups({"Main"})
     */
    private $enabled;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetimetz")
     * @Groups({"Main"})
     */
    private $createdAt;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({"Main"})
     * @Assert\NotBlank()
     */
    private $sex;
    
    /**
     * @var int
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"Main"})
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^\d{10}$/")
     */
    private $phone;

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        $roles[] = self::ROLE_DEFAULT;

        return array_unique($roles);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
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

    /**
     * @return string|null
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param int $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return int
     */
    public function getFormattedPhone()
    {
        return sprintf('+7 (%s) %s %s-%s',
            substr($this->phone, 0, 3),
            substr($this->phone, 3, 3),
            substr($this->phone, 5, 2),
            substr($this->phone, 7, 2)
        );
    }

    /**
     * @param int $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return sprintf('%s %s %s', $this->lastname, $this->firstname, $this->surname);
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return sprintf(
            '%s %s. %s.',
            ucfirst($this->lastname),
            mb_strtoupper(mb_substr($this->firstname, 0, 1)),
            mb_strtoupper(mb_substr($this->surname, 0, 1)));
    }

    public function __toString()
    {
        // TODO OVERRIDE toString
        return '';
    }

}