<?php

namespace Test\CrudBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="UserRoles", inversedBy="users")
     * @ORM\JoinColumn(name="userRolesId", referencedColumnName="id")
     */
    protected $userRoles;

    /**
     * @ORM\ManyToMany(targetEntity="UserAddress", inversedBy="users",  cascade={"persist", "remove"})
     * @ORM\JoinTable(name="users_userAddresses")
     **/
    protected $userAddresses;

    public function __construct()
    {
        $this->userAddresses = new ArrayCollection();
    }


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=30)
     * @Assert\NotBlank()
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=30)
     * @Assert\NotBlank()
     */
    protected $lastName;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="smallint")
     * @Assert\NotBlank()
     * @Assert\Length(max = 3)
     */
    protected $age;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 6,
     *      max = 4096,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} characters"
     * )
     */
    protected $password;


    /**
     * Геттер для имени пользователя.
     *
     * @return string The username.
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $encoder = new BCryptPasswordEncoder(12);
        $enc_password = $encoder->encodePassword($password, $this->getSalt());

        $this->password = $enc_password;
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return [$this->userRoles->getRole()];
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set userRoles
     *
     * @param \Test\CrudBundle\Entity\UserRoles $userRoles
     * @return User
     */
    public function setUserRoles(UserRoles $userRoles = null)
    {
        $this->userRoles = $userRoles;

        return $this;
    }

    /**
     * Get userRoles
     *
     * @return \Test\CrudBundle\Entity\UserRoles
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * Add userAddresses
     *
     * @param \Test\CrudBundle\Entity\UserAddress $userAddresses
     * @return User
     */
    public function addUserAddress(\Test\CrudBundle\Entity\UserAddress $userAddresses)
    {
        $this->userAddresses[] = $userAddresses;

        return $this;
    }

    /**
     * Remove userAddresses
     *
     * @param \Test\CrudBundle\Entity\UserAddress $userAddresses
     */
    public function removeUserAddress(\Test\CrudBundle\Entity\UserAddress $userAddresses)
    {
        $this->userAddresses->removeElement($userAddresses);
    }

    /**
     * Get userAddresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserAddresses()
    {
        return $this->userAddresses;
    }

    /**
     * Сброс прав пользователя.
     */
    public function eraseCredentials()
    {

    }
}
