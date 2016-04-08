<?php namespace IEPC\FilesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use IEPC\WebsiteBundle\Entity\Content;

use IEPC\ContentBundle\Entity\Section;

/**
 * @ORM\Entity(repositoryClass="IEPC\FilesBundle\Repository\DocumentCollectionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 */
class DocumentCollection extends Content
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

    protected $title;

    protected $content; // Elastic Search

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="IEPC\ContentBundle\Entity\Section");
     */
    protected $section;

    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="IEPC\ContentBundle\Entity\Section");
     */
    protected $file;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Getter and setters">

    /**
     * @return Section
     */
    public function getSection() {
        return $this->section;
    }

    /**
     * @param Section $section
     * @return File
     */
    public function setSection($section) {
        $this->section = $section;
        return $this;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function __construct(UploadedFile $file = NULL) {
        if ($file) {
            $this->setFile($file);
        }
    }

    public function __toString() {
        return $this->getWebPath();
    }

    public function getAbsolutePath() {
        return NULL === $this->path
            ? NULL
            : $this->getUploadRootDir() . '/' . $this->getId() . '.' . $this->getPath();
    }

    public function getWebPath() {
        return NULL === $this->path
            ? NULL
            : '/' . $this->getUploadDir() . '/' . $this->getId() . '.' . $this->getPath();
    }

    protected function getUploadRootDir() {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        return 'files';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (NULL === $this->getFile()) {
            return;
        }

        if ($this->getTemp()) {
            unlink($this->getTemp());
            $this->setTemp(NULL);
        }

        $extension = $this->getFile()
            ->guessClientExtension() ?: $this->getFile()
            ->getClientOriginalExtension();

        $localFile = $this->getFile()->move(
            $this->getUploadRootDir(), "{$this->getId()}.{$extension}"
        );

        chmod($localFile->getPathname(), 0660);
        $this->setFile(NULL);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if ($this->getTemp()) {
            unlink($this->getTemp());
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove() {
        $this->setTemp($this->getAbsolutePath());
    }

    public function getContent()
    {

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