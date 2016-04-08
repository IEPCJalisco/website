<?php namespace IEPC\FilesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

use IEPC\ContentBundle\Entity\Section;

/**
 * @ORM\Entity(repositoryClass="IEPC\FilesBundle\Repository\DocumentVersionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 */
class DocumentVersion
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
     * @ORM\Column(length=10)
     */
    protected $version;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="IEPC\FilesBundle\Entity\File");
     */
    protected $file;

    /**
     * @var Document
     *
     * @ORM\ManyToOne(targetEntity="IEPC\DocumentBundle\Entity\Document", inversedBy="versions")
     */
    protected $document;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Getter and setters">

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @param string $version
     * @return DocumentVersion
     */
    public function setVersion($version) {
        $this->version = $version;
        return $this;
    }

    /**
     * @return Section
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param Section $file
     * @return DocumentVersion
     */
    public function setFile($file) {
        $this->file = $file;
        return $this;
    }

    /**
     * @return Document
     */
    public function getDocument() {
        return $this->document;
    }

    /**
     * @param Document $document
     * @return DocumentVersion
     */
    public function setDocument($document) {
        $this->document = $document;
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

    // </editor-fold>
}