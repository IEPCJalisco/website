<?php namespace IEPC\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="IEPC\PageBundle\Repository\PageRepository")
 */
class Page
{
    // <editor-fold defaultstate="collapsed" desc="Constants">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Properties">

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, unique=true)
     */
    private $path;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Getter and Setters">

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Page
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">
    // </editor-fold>
}
