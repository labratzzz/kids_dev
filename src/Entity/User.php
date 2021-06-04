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
 * @UniqueEntity(fields={"email"}, message="Профиль пользователя на данную электронную почту уже зарегистрирован.")
 * @ORM\Table(name="users")
 */
class User implements AdvancedUserInterface
{
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
     * @Assert\Email(groups={"Patient", "Doctor"})
     * @Assert\NotBlank(groups={"Patient", "Doctor"})
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\Email(groups={"Patient", "Doctor"})
     * @Assert\NotBlank(groups={"Patient", "Doctor"})
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\NotBlank(groups={"Patient", "Doctor"})
     */
    private $name;

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
     * @Assert\NotBlank(groups={"Patient", "Doctor"})
     */
    private $sex;

    /**
     * @var int
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"Main"})
     * @Assert\NotBlank(groups={"Patient"})
     * @Assert\Regex(pattern="/^\d{10}$/", groups={"Patient"})
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

    public function __toString()
    {
        // TODO OVERRIDE toString
        return '';
    }

}