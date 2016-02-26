<?php namespace IEPC\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="IEPC\ContentBundle\Repository\WebPageRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(indexes={
 *     @ORM\Index(name="idx_fullPath", columns={"full_path"})
 * })
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
     * @ORM\Column(length=48)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(length=255)
     */
    protected $fullPath;

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
    public function getPath() {
        return $this->path;
    }

    /**
     * @param string $path
     * @return WebPage
     */
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullPath() {
        return $this->fullPath;
    }

    /**
     * @return WebPage
     */
    public function setFullPath() {
        $this->fullPath = $this->getSection()->getFullPath() . $this->getPath();
        return $this;
    }

    /**
     * @return Section
     */
    public function getSection() {
        return $this->section;
    }

    /**
     * @param Section $section
     * @return WebPage
     */
    public function setSection(Section $section) {
        $this->section = $section;
        return $this;
    }

    /**
     * @return Content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param Content $content
     * @return WebPage
     */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }



    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function __construct()
    {
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
