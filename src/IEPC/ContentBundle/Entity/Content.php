<?php namespace IEPC\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IEPC\ContentBundle\Model\ContentInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\MappedSuperclass()
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\Entity(repositoryClass="IEPC\ContentBundle\Repository\ContentRepository")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "content" = "Content",
 *     "page"    = "IEPC\WebsiteBundle\Entity\Page"
 * })
 * @ORM\Table(indexes={
 *     @ORM\Index(name="idx_discr", columns={"discr"})}
 * )
 *
 * @package IEPCContentBundle
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

    public function renderJson() {
        return json_encode(array(
            'id' => $this->getId()
        ));
    }

    public function renderHtml() {
        $id = $this->getId();
        return "<article>Content Id: <strong>{ $id }</strong> </article>";
    }

    // </editor-fold>
}
