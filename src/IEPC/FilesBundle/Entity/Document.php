<?php namespace IEPC\FilesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use IEPC\WebsiteBundle\Entity\Content;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="IEPC\FilesBundle\Repository\DocumentRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 *
 * @package IEPC\FilesBundle\Entity
 */
class Document extends Content
{
    // <editor-fold defaultstate="collapsed" desc="Constants">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Properties">

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(length=256)
     */
    protected $title; // Elastic Search

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $description; // Elastic Search

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $content; // Elastic Search

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $date;

    /**
     * @var string
     *
     * @ORM\Column(length=700)
     */
    protected $path;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="IEPC\FilesBundle\Entity\DocumentVersion", mappedBy="document")
     */
    protected $versions;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Tag")
     */
    protected $tags;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Getter and setters">

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Document
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
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
     * @return Document
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \Datetime $date
     * @return Document
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * @param ArrayCollection $versions
     * @return Document
     */
    public function setVersions($versions)
    {
        $this->versions = $versions;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     * @return Document
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    /**
     * Document constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->getTitle();
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Static Functions">
    // </editor-fold>
}