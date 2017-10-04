<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 07.09.17
 * Time: 19:47
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Publication
 * @package AppBundle\Entity
 * @ORM\Entity
 */

class Publication implements Translatable
{

    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @Gedmo\Translatable
     *
     * @Assert\NotBlank
     */
    protected $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title", "createdAt"})
     *
     * @ORM\Column(type="string", length=128, nullable=false, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     *
     * @ORM\Column(type="text", length=2550)
     */
    protected $description;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     *
     * @ORM\Column(type="text", length=255)
     */
    protected $shortDescription;

    /**
     * @var \DateTime $publishedAt
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank
     *
     * @Gedmo\Timestampable(on="create")
     */
    protected $publishedAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank
     *
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @var User $author
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="publications")
     */
    protected $author;

    /**
     * @var array User $likedUsers
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="likedPublications")
     */
    protected $likedUsers;

    /**
     * Publication constructor.
     */
    public function __construct()
    {
        $this->likedUsers = new ArrayCollection();
        $this->publishedAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

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
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param \DateTime $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }



    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

}