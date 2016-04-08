<?php namespace IEPC\FilesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use IEPC\WebsiteBundle\Entity\Content;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

use IEPC\ContentBundle\Entity\Section;

/**
 * @ORM\Entity(repositoryClass="IEPC\FilesBundle\Repository\DocumentRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
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
    protected $content; // Elastic Search

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $keywords;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime")
     */
    protected $date;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="IEPC\FilesBundle\Entity\DocumentVersion", mappedBy="document")
     */
    protected $versions;

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
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     * @return Document
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
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

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function __construct(UploadedFile $file = null)
    {
        if ($file) {
            $this->setFile($file);
        }
    }

    public function __toString()
    {
        return $this->getWebPath();
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->getId() . '.' . $this->getPath();
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : '/' . $this->getUploadDir() . '/' . $this->getId() . '.' . $this->getPath();
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'files';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        if ($this->getTemp()) {
            unlink($this->getTemp());
            $this->setTemp(null);
        }

        $extension = $this->getFile()->guessClientExtension()?: $this->getFile()->getClientOriginalExtension();

        $localFile = $this->getFile()->move(
            $this->getUploadRootDir(), "{$this->getId()}.{$extension}"
        );

        chmod($localFile->getPathname(), 0660);
        $this->setFile(null);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->getTemp()) {
            unlink($this->getTemp());
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->setTemp($this->getAbsolutePath());
    }

    public function getContent() {
        // TODO: Implement getContent() method.
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Static Functions">

    public static function getEntityName()
    {
        return 'Página';
    }

    public static function getEntityNamePlural()
    {
        return 'Páginas';
    }

    // </editor-fold>
}