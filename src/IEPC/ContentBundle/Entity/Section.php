<?php namespace IEPC\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use IEPC\ContentBundle\Entity\WebPage;

/**
 * @ORM\Table(name="section")
 * @ORM\Entity(repositoryClass="IEPC\ContentBundle\Repository\SectionRepository")
 *
 * @UniqueEntity({"path", "parent"})
 *
 * @package IEPC\ContentBundle\Entity
 *
 * @TODO Make option to disable/unpublish entire section
 */
class Section
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
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(length=128)
     * @Assert\Regex("/^[a-z0-9_-]{0,128}$/")
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(length=128, nullable=true)
     */
    protected $layout;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="children")
     */
    protected $parent;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Section", mappedBy="parent")
     */
    protected $children;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="IEPC\ContentBundle\Entity\WebPage", mappedBy="section")
     */
    protected $webPages;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Getter and setters">

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $children
     * @return Section
     */
    public function setChildren(ArrayCollection $children) {
        $this->children = $children;
        return $this;
    }

    /**
     * @return \IEPC\ContentBundle\Entity\Section
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @param \IEPC\ContentBundle\Entity\Section $parent
     * @return Section
     */
    public function setParent(Section $parent) {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Section
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Section
     */
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getLayout() {
        return $this->layout;
    }

    /**
     * @param string $layout
     * @return Section
     */
    public function setLayout($layout) {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getWebPages() {
        return $this->webPages;
    }

    /**
     * @param ArrayCollection $webPages
     * @return Section
     */
    public function setWebPages($webPages) {
        $this->webPages = $webPages;
        return $this;
    }

    /**
     * @param WebPage $webPage
     * @return Section
     */
    public function addWebPage(WebPage $webPage)
    {
        if (!$this->getWebPages()->contains($webPage)) {
            $this->getWebPages()->add($webPage);
            $webPage->setSection($this);
        }
        return $this;
    }

    /**
     * @param \IEPC\ContentBundle\Entity\WebPage $webPage
     * @return Section
     */
    public function removeWebPage(WebPage $webPage)
    {
        $this->getWebPages()->removeElement($webPage);
        return $this;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function __construct($name = null)
    {
        if ($name) {
            $this->setName($name);
        }

        $this->setChildren(new ArrayCollection());
        $this->setWebPages(new ArrayCollection());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function getActiveLayout()
    {
        if (!$this->layout && $this->getParent()) {
            return $this->getParent()->getLayout();
        }
        return $this->layout;
    }

    /**
     * @return string
     */
    public function getFullPath()
    {
        if ($this->getParent()) {
            return ($this->getParent()->getFullPath() != '/'?$this->getParent()->getFullPath():'') . '/' . $this->getPath();
        }
        else {
            return $this->getPath();
        }
    }

    // </editor-fold>
}
