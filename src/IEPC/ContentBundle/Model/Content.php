<?php namespace IEPC\ContentBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @package IEPC\ContentBundle\Model
 */
abstract class Content implements ContentInterface
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
    protected $name;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="IEPC\ContentBundle\Entity\WebPage", mappedBy="content")
     */
    protected $webPages;

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
     * @return Content
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Content
     */
    public function setWebPages(ArrayCollection $webPages) {
        $this->webPages = $webPages;
        return $this;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function __construct()
    {
        $this->setWebPages(new ArrayCollection());
    }

    public function renderJson()
    {
        return json_encode([
            'id' => $this->getId()
        ]);
    }

    public function renderHtml()
    {
        $id = $this->getId();
        return "<article>Content Id: <strong>{ $id }</strong> </article>";
    }

    public function __toString()
    {
        return $this->getName();
    }

    // </editor-fold>
}
