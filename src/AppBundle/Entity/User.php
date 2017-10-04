<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 02.10.17
 * Time: 19:54
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Entity
 */

class User implements UserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer", unique=true)
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $username
     *
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank
     */
    protected $username;

    /**
     * @var string $username
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    protected $firstName;

    /**
     * @var string $username
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    protected $lastName;

//    /**
//     * @var string $password
//     *
//     * @ORM\Column(type="string", length=255)
//     *
//     * @Assert\NotBlank
//     */
    protected $password;

    /**
     * @var string $email
     *
     * @ORM\Column(type="string", unique=true)
     *
     * @Assert\NotBlank
     *
     * @Assert\Email
     *
     */
    protected $email;

    /**
     * @var integer $vkontakteId
     *
     * @ORM\Column(type="integer", unique=true, nullable=true)
     */

    protected $vkontakteId;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank
     *
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

//    /**
//     * @ORM\Column(type="string", length=255)
//     *
//     * @var string salt
//     */
    protected $salt;

    /**
     * @var array Publication $publications
     *
     * @ORM\OneToMany(targetEntity="Publication", mappedBy="author")
     */
    protected $publications;

    /**
     * @var array User $likedPublications
     *
     * @ORM\ManyToMany(targetEntity="Publication", inversedBy="likedUsers")
     */
    protected $likedPublications;

//    /**
//     * @var string $apiKey
//     *
//     * @ORM\Column(type="string", unique=true)
//     */
    protected $apiKey;

    /**
     *
     * User constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->publications = new ArrayCollection();
        $this->likedPublications = new ArrayCollection();
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return array('ROLE_USER');
    }


    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(): string
    {
        return $this->username ;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getVkontakteId(): int
    {
        return $this->vkontakteId;
    }

    /**
     * @param int $vkontakteId
     */
    public function setVkontakteId(int $vkontakteId)
    {
        $this->vkontakteId = $vkontakteId;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return array
     */
    public function getPublications(): array
    {
        return $this->publications;
    }

    /**
     * @param array $publications
     */
    public function setPublications(array $publications)
    {
        $this->publications = $publications;
    }

    /**
     * @return array
     */
    public function getLikedPublications(): array
    {
        return $this->likedPublications;
    }

    /**
     * @param array $likedPublications
     */
    public function setLikedPublications(array $likedPublications)
    {
        $this->likedPublications = $likedPublications;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }


}
