<?php namespace IEPC\FilesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="IEPC\FilesBundle\Repository\FileRepository")
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
     * @ORM\Column(length=255)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(length=255)
     */
    protected $type;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime", nullable=true);
     */
    protected $uploadDate;

    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $file;

    protected $temp;

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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        if ($file) {
            if (is_file($this->getAbsolutePath())) {
                $this->setTempFile($this->getAbsolutePath());
            }

            $extension = $file->guessClientExtension()?: $file->getClientOriginalExtension();

            $this->setUploadDate((new \DateTime('now')));

            $this->setPath($extension)
                ->setName($file->getClientOriginalName())
                ->setType($file->getType());
        }
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param $tempFile
     * @return File
     */
    public function setTempFile($tempFile)
    {
        $this->temp = $tempFile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempFile()
    {
        return $this->temp;
    }

    /**
     * @return \Datetime
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    /**
     * @param $uploadDate
     * @return File
     */
    public function setUploadDate($uploadDate)
    {
        $this->uploadDate = $uploadDate;
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

        if ($this->getTempFile()) {
            unlink($this->getTempFile());
            $this->setTempFile(null);
        }

        $extension = $this->getFile()->guessClientExtension()?: $this->getFile()->getClientOriginalExtension();

        $localFile = $this->getFile()->move(
            $this->getUploadRootDir(), "{$this->getId()}.{$extension}"
        );

        //chmod($localFile->getPathname(), 0664);
        $this->setFile(null);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->getTempFile()) {
            unlink($this->getTempFile());
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->setTempFile($this->getAbsolutePath());
    }

    // </editor-fold>
}