<?php namespace IEPC\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use IEPC\WebsiteBundle\Entity\Content;

/**
 * @ORM\Entity(repositoryClass="IEPC\ContentBundle\Repository\WebPageRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(indexes={
 *     @ORM\Index(name="idx_fullPath", columns={"full_path"})
 * })
 * @UniqueEntity("fullPath")
 *
 * @package IEPC\ContentBundle\Entity
 * 
 * @TODO Make fields for meta tags for social sharing
 * @TODO Make option to publish/unpublish
 * @TODO Make Uniqueness only for published pages (repositoryMethod)
 *
 * @TODO Make Interface to make webpages searchables by elasticsearch api
 */
class WebPage
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
     * @ORM\Column(length=128)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(length=1250)
     */
    protected $fullPath;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $showOnMenu;

    /**
     * @var string
     *
     * @ORM\Column(length=128, nullable=true)
     */
    protected $layout;

    protected $internalName;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="IEPC\ContentBundle\Entity\Section", inversedBy="webPages");
     */
    protected $section;

    /**
     * @var Content
     *
     * @ORM\ManyToOne(targetEntity="IEPC\ContentBundle\Model\ContentInterface", inversedBy="webPages")
     */
    protected $content;

    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="WebPage", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    protected $parent;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="WebPage", mappedBy="parent")
     */
    protected $children;

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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return WebPage
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * @return WebPage
     */
    public function setFullPath()
    {
        if (strlen($this->getPath()) == 0 ) {
            $this->fullPath = $this->getSection()->getFullPath();
        }
        else {
            if ($this->getParent()) {
                $this->fullPath = $this->getParent()->getFullPath() != '/' ? $this->getParent()->getFullPath() : '';
            }
            else {
                $this->fullPath  = $this->getSection()->getFullPath() != '/' ? $this->getSection()->getFullPath() : '';
            }

            $this->fullPath .= '/' . $this->getPath();
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isShowOnMenu()
    {
        return $this->showOnMenu;
    }

    /**
     * @return boolean
     */
    public function showsOnMenu()
    {
        return $this->isShowOnMenu();
    }

    /**
     * @param boolean $showOnMenu
     * @return WebPage
     */
    public function setShowOnMenu($showOnMenu)
    {
        $this->showOnMenu = $showOnMenu;
        return $this;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     * @return WebPage
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param Section $section
     * @return WebPage
     */
    public function setSection(Section $section)
    {
        $this->section = $section;
        return $this;
    }

    /**
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Content $content
     * @return WebPage
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $children
     * @return WebPage
     */
    public function setChildren(ArrayCollection $children)
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return \IEPC\ContentBundle\Entity\Section
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param $parent
     * @return WebPage
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function __construct()
    {
        $this->setShowOnMenu(false);
    }

    public function __toString() {
        return $this->getFullPath();
    }

    public function getActiveLayout()
    {
        return $this->getLayout() ?: $this->getSection()->getActiveLayout();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateFullPath()
    {
        // @todo Prevent change of route without fixing seo an redirect issues
        $this->setFullPath();
    }

    // </editor-fold>
}
