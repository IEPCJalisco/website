<?php namespace IEPC\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IEPC\ContentBundle\Model\ContentInterface;

/**
 * @ORM\MappedSuperclass()
 * @ORM\Entity(repositoryClass="IEPC\ContentBundle\Repository\ContentRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "revistafoliospage" = "RevistaFoliosPage",
 *     "article"           = "Article",
 *     "author"            = "Author",
 *     "magazine"          = "Magazine",
 *     "podcast"           = "Podcast",
 *     "category"          = "Category",
 *     "staticpage"        = "StaticPage",
 *     "gallery"           = "Gallery",
 *     "video"             = "Video",
 *     "infographic"       = "Infographic"
 * })
 * @ORM\Table(indexes={
 *     @ORM\Index(name="slug_idx", columns={"slug"}),
 *     @ORM\Index(name="path_idx", columns={"path"})
 * })
 *
 * @author iZam b. <izma@mabkil.com>
 * @package IEPCContentBundle
 */
abstract class Content implements ContentInterface
{

}

