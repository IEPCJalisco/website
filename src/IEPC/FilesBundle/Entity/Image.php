<?php namespace IEPC\FilesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="IEPC\FilesBundle\Repository\ImageRepository")
 * @ORM\Table()
 *
 * @package IEPC\FilesBundle\Entity
 */
class Image extends File
{
    // <editor-fold defaultstate="collapsed" desc="Constants">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Properties">

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $width;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $height;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Getter and setters">

    /**
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * @param int $width
     * @return Image
     */
    public function setWidth($width) {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * @param int $height
     * @return Image
     */
    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">
    // </editor-fold>
}