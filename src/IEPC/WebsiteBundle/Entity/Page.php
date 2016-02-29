<?php namespace IEPC\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IEPC\ContentBundle\Entity\Content;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="IEPC\WebsiteBundle\Repository\PageRepository")
 *
 * @package IEPCWebsiteBundle
 */
class Page extends Content
{
    // <editor-fold defaultstate="collapsed" desc="Constants">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Properties">

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $content;

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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function __construct()
    {
        parent::__construct();
        $this->setContent('');
    }

    public function renderHtml() {
        return $this->getContent();
    }

    public function renderJson() {
        // TODO: Implement renderJson() method.
    }

    // </editor-fold>
}
