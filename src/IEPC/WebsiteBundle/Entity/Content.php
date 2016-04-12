<?php namespace IEPC\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use IEPC\ContentBundle\Model\Content as ContentBase;

/**
 * @ORM\MappedSuperclass()
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\Entity(repositoryClass="IEPC\WebsiteBundle\Repository\ContentRepository")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "content"            = "Content",
 *     "page"               = "IEPC\WebsiteBundle\Entity\Page",
 *     "event"              = "IEPC\WebsiteBundle\Entity\Event",
 *     "bulletin"           = "IEPC\WebsiteBundle\Entity\Bulletin",
 *     "news"               = "IEPC\WebsiteBundle\Entity\News",
 *     "gallery"            = "IEPC\WebsiteBundle\Entity\Gallery",
 *     "document"           = "IEPC\FilesBundle\Entity\Document",
 *     "documentcollection" = "IEPC\FilesBundle\Entity\DocumentCollection"
 * })
 * @ORM\Table(
 *     indexes={@ORM\Index(name="idx_discr", columns={"discr"})},
 *     uniqueConstraints={@ORM\UniqueConstraint(name="idx_name", columns={"name"})}
 * )
 * @UniqueEntity("name")
 *
 * @package IEPCWebsiteBundle
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
