<?php namespace IEPC\FilesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as HttpFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="IEPC\FilesBundle\Repository\FileRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "file"  = "File",
 *     "image" = "Image"
 * })
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 */
class File
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
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(length=8)
     */
    protected $extension;

    /**
     * @var string
     *
     * @ORM\Column(length=128)
     */
    protected $mime;

    /**
     * @var string
     *
     * @ORM\Column(length=256)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(length=64)
     */
    protected $checksum;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime", nullable=true);
     */
    protected $date;

    protected $file;

    protected $fileToDelete;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return File
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @param string $mime
     * @return File
     */
    public function setMime($mime)
    {
        $this->mime = $mime;
        return $this;
    }

    /**
     * @return string
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * @param string $checksum
     * @return File
     */
    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;
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
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\File $file
     * @return file
     */
    public function setFile(HttpFile $file = null)
    {
        $this->file = $file;

        if ($file) {
            if (is_file($this->getAbsolutePath())) {
                $this->setFileToDelete($this->getAbsolutePath());
            }

            $extension = $file->guessExtension() ?: $file->getExtension();

            $this->setExtension($extension)
                ->setName($file->getFilename())
                ->setMime($file->getMimeType())
                ->setDate((new \DateTime('now')))
                ->setChecksum(hash_file('sha256', $file));
        }

        return $this;
    }

    /**
     * @return HttpFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param $fileToDelete
     * @return File
     */
    public function setFileToDelete($fileToDelete)
    {
        $this->fileToDelete = $fileToDelete;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileToDelete()
    {
        return $this->fileToDelete;
    }

    /**
     * @return \Datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     * @return File
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
    
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    /**
     * File constructor.
     * @param \Symfony\Component\HttpFoundation\File\File $file
     * @param $path - Relative to KernelRoot
     *
     *
     */
    public function __construct(HttpFile $file, $path)
    {
        $this->setPath($path)
            ->setFile($file);
    }

    public function __toString()
    {
        return $this->getWebPath();
    }

    public function getAbsolutePath()
    {
        return $this->getRootDir() . 'web/files/' . $this->getPath() . '/' . $this->getFileSystemName();
    }

    public function getWebPath()
    {
        return '/files/' . $this->getPath() . '/' . $this->getFileSystemName();
    }

    protected function getUploadBaseDir()
    {
        return $this->getRootDir() . 'web/files/' . $this->getPath();
    }

    protected function getFileSystemName()
    {
        if ($this->getExtension()) {
            return "{$this->getId()}.{$this->getExtension()}";
        }
        else {
            return "{$this->getId()}";
        }
    }

    protected final function getRootDir()
    {
        return __DIR__ . '/../../../../';
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

        $this->removeFile();

        $localFile = $this->getFile()->move(
            $this->getUploadBaseDir(), $this->getFileSystemName()
        );

        chmod($localFile->getPathname(), 0660);

        $this->setFile(null);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeFile()
    {
        if ($this->getFileToDelete()) {
            unlink($this->getFileToDelete());
            $this->setFileToDelete(null);
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function setFileToRemove()
    {
        $this->setFileToDelete($this->getAbsolutePath());
    }

    // </editor-fold>
}