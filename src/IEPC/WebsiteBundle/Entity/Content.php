<?php namespace IEPC\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IEPC\ContentBundle\Model\Content as ContentBase;

/**
 * @ORM\MappedSuperclass()
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\Entity(repositoryClass="IEPC\ContentBundle\Repository\ContentRepository")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "content"            = "Content",
 *     "page"               = "IEPC\WebsiteBundle\Entity\Page",
 *     "event"              = "IEPC\WebsiteBundle\Entity\Event",
 *     "bulletin"           = "IEPC\WebsiteBundle\Entity\Bulletin",
 *     "news"               = "IEPC\WebsiteBundle\Entity\News",
 *     "gallery"            = "IEPC\WebsiteBundle\Entity\Gallery",
 *     "document"           = "IEPC\DocumentBundle\Entity\Document",
 *     "documentcollection" = "IEPC\DocumentBundle\Entity\DocumentCollection"
 * })
 * @ORM\Table(indexes={
 *     @ORM\Index(name="idx_discr", columns={"discr"})}
 * )
 *
 * @package IEPCContentBundle
 */
abstract class Content extends ContentBase
{
    // <editor-fold defaultstate="collapsed" desc="Constants">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Properties">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Relations">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Getter and setters">
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Functions">
    // </editor-fold>
}
