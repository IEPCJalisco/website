<?php namespace IEPC\FilesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use IEPC\WebsiteBundle\Entity\Content;

use IEPC\ContentBundle\Entity\Section;

/**
 * @ORM\Entity(repositoryClass="IEPC\FilesBundle\Repository\DocumentCollectionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 *
 * @package IEPC\FilesBundle\Entity
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

    /**
     * @var string
     *
     * @ORM\Column(length=256)
     */
    protected $title;

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Document")
     * @ORM\JoinTable(name="document_document_collection",
     *      joinColumns={@ORM\JoinColumn(name="document_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="document_collection_id", referencedColumnName="id")}
     *      )
     */
    protected $documents;

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
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     * @return DocumentCollection
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDocuments() {
        return $this->documents;
    }

    /**
     * @param ArrayCollection $documents
     * @return DocumentCollection
     */
    public function setDocuments($documents) {
        $this->documents = $documents;
        return $this;
    }

    /**
     * @param \IEPC\FilesBundle\Entity\Document $document
     * @return DocumentCollection
     */
    public function addDocument(Document $document)
    {
        if (!$this->getDocuments()->contains($document)) {
            $this->getDocuments()->add($document);
        }
        return $this;
    }

    /**
     * @param \IEPC\FilesBundle\Entity\Document $document
     * @return DocumentCollection
     */
    public function removeDocument(Document $document)
    {
        $this->getDocuments()->removeElement($document);
        return $this;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function __construct()
    {
        $this->setDocuments(new ArrayCollection());
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getContent()
    {
        return $this->getTitle();
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Static Functions">

    // </editor-fold>
}