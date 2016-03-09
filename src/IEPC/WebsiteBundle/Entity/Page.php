<?php namespace IEPC\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IEPC\ContentBundle\Entity\Content;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="IEPC\WebsiteBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks()
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

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function replaceContentImages()
    {
        $this->setContent( str_replace('../../../imagenes/tmp', '/imagenes/articles', $this->getContent()) );
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function moveContentImages()
    {
        // @todo Make a way to delete orphaned images
        preg_match_all('/src="([^"]+)"/', $this->getContent(), $images);
        $rootDir =  __DIR__.'/../../../../web/';

        foreach($images[0] as $image) {
            $image     = substr(substr($image, 5), 0, -1);
            $imageName = pathinfo($image, PATHINFO_FILENAME) . '.' . pathinfo($image, PATHINFO_EXTENSION);

            $webPath = 'imagenes/articles';
            $tmpPath = 'imagenes/tmp';

            if (!file_exists($rootDir . "imagenes/articles")) {
                mkdir($rootDir . "imagenes/articles", 0777, true);
            }

            if (!file_exists("{$rootDir}.{$webPath}/{$imageName}")) {
                if (file_exists("{$rootDir}{$tmpPath}/{$imageName}")) {
                    rename("{$rootDir}{$tmpPath}/{$imageName}", "{$rootDir}{$webPath}/{$imageName}");
                }
            }
        }
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Static Functions">

    public static function getEntityName()
    {
        return 'Página';
    }

    public static function getEntityNamePlural()
    {
        return 'Páginas';
    }

    // </editor-fold>
}
