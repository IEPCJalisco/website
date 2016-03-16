<?php namespace IEPC\ContentBundle\Service;

use IEPC\ContentBundle\Model\ContentInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContentManager implements ContainerAwareInterface
{
    private $container;

    public function getContentTypes()
    {
        $contentTypes = $this->container->getParameter('content')['types'];

        return $contentTypes;
    }

    public function getContentEditRoute($id)
    {
        $em = $this->container->get('doctrine')->getManager();

        // @todo fix harcode route
        if (null !== $id) {
            $entity = $em->getRepository('IEPCContentBundle:Content')
                ->find($id);
            $class = get_class($entity);

            $contents = $this->getContentTypes();
        }
        else {
            return 'iepc_website_admin_content_page';
        }

        return $contents[$class]['edit_route'];
    }

    /**
     * @param \IEPC\ContentBundle\Model\ContentInterface $contentEntity
     * @param string $content
     * @return string
     */
    public function updateFileRoutes(ContentInterface $contentEntity, $content)
    {
        $tmp_dir = $this->container->getParameter('content')['tmp_dir'];
        $files_dir = $this->container->getParameter('content')['files_dir'];
        $webDir =  $this->container->get('kernel')->getRootDir() . '/../web/';

        $entityType = explode('\\', get_class($contentEntity));
        $entityType = array_pop($entityType);
        $files_dir = str_replace(['{type}','{id}'], [strtolower($entityType), $contentEntity->getId()], $files_dir);

        preg_match_all('/src="([^"]+)"/',  $content, $images);
        preg_match_all('/href="([^"]+)"/', $content, $files);

        $links = array_merge($images[0], $files[0]);

        foreach ($links as $originalLink) {
            $link = substr($originalLink, 0, (strlen($originalLink) - 1));
            $protocol = $this->startsWith($originalLink, 'src')?'src':'href';

            if ($this->endsWith($link, '?iepc_tmp')) {
                $filename = explode('/', $link);
                $filename = array_pop($filename);
                $filename = substr($filename, 0, strpos($filename, '?'));

                $originalFile = $webDir . $tmp_dir . '/' . $filename;
                $destFile     = $webDir . $files_dir . '/' . $filename;

                if (!file_exists($webDir . $files_dir)) {
                    mkdir($webDir . $files_dir, 0770, true);
                }
                rename($originalFile, $destFile);
                $content = str_replace($originalLink, "{$protocol}=\"/{$files_dir}/{$filename}\"", $content);
            }
        }
        return $content;
    }

    /**
     * @param \IEPC\ContentBundle\Model\ContentInterface $entity
     * @param string $content
     */
    public function cleanOrphans(ContentInterface $entity, $content)
    {
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function __construct(Container $container)
    {
        $this->setContainer($container);
    }

    private function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }

    private function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}

