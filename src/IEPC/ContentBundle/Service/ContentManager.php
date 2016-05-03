<?php namespace IEPC\ContentBundle\Service;

use IEPC\ContentBundle\Model\ContentInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package IEPC\ContentBundle\Service
 */
class ContentManager implements ContainerAwareInterface
{
    private $container;

    /**
     * @return mixed
     */
    public function getContentTypes()
    {
        $contentTypes = $this->container->getParameter('content')['types'];

        return $contentTypes;
    }

    /**
     * @param \IEPC\ContentBundle\Model\ContentInterface $content
     *
     * @return mixed
     */
    public function getBundleName(ContentInterface $content)
    {
        $classNameArray = explode('\\', preg_replace('/\\\\/', '', get_class($content), 1));

        return $classNameArray[0];

//        $bundles = $this->getContainer()->get('kernel')->getBundles()
//        $dataBaseNamespace = substr($entityNamespace, 0, strpos($entityNamespace, '\\Entity\\'));
//        foreach ($bundles as $type => $bundle) {
//            $bundleRefClass = new \ReflectionClass($bundle);
//            if ($bundleRefClass->getNamespaceName() === $dataBaseNamespace) {
//                return $type;
//            }
//        }
//        return null;
    }

    /**
     * @param \IEPC\ContentBundle\Model\ContentInterface $content
     * @param string $format
     * @param string $layout
     *
     * @return string
     */
    private function getLayout(ContentInterface $content, $format = 'html', $layout = 'default')
    {
        $classNameArray = explode('\\', preg_replace('/\\\\/', '', get_class($content), 1));

        $bundleDir = $classNameArray[0];
        $entityName = strtolower(array_pop($classNameArray));

        $layoutName = "{$bundleDir}:_content/{$entityName}:{$layout}.{$format}.twig";

        return $layoutName;
    }

    /**
     * @param \IEPC\ContentBundle\Model\ContentInterface $content
     * @param string $format
     * @param string $layout
     *
     * @return mixed
     */
    public function render(ContentInterface $content, $format = 'html', $layout = 'default')
    {
        $templating = $this->container->get('templating');

        try {
            $response = $templating->render($this->getLayout($content, $format, $layout), [
                'content' => $content
            ]);
        }
        catch (\InvalidArgumentException $e) {
            $response = $templating->render("IEPCContentBundle:_content:default.{$format}.twig", [
                'content' => $content
            ]);
        }
        return $response;
    }

    /**
     * @param \IEPC\ContentBundle\Model\ContentInterface $contentEntity
     * @param string $content
     *
     * @return string
     */
    public function updateFileRoutes(ContentInterface $contentEntity, $content)
    {
        $tmp_dir = $this->container->getParameter('content')['tmp_dir'];
        $files_dir = $this->container->getParameter('content')['files_dir'];
        $webDir = $this->container->get('kernel')->getRootDir() . '/../web/';

        $entityType = explode('\\', get_class($contentEntity));
        $entityType = array_pop($entityType);
        $files_dir = str_replace(['{type}', '{id}'], [
            strtolower($entityType),
            $contentEntity->getId()
        ], $files_dir);

        preg_match_all('/src="([^"]+)"/', $content, $images);
        preg_match_all('/href="([^"]+)"/', $content, $files);

        $links = array_merge($images[0], $files[0]);

        foreach ($links as $originalLink) {
            $link = substr($originalLink, 0, (strlen($originalLink) - 1));
            $protocol = $this->startsWith($originalLink, 'src') ? 'src' : 'href';

            if ($this->endsWith($link, '?iepc_tmp')) {
                $filename = explode('/', $link);
                $filename = array_pop($filename);
                $filename = substr($filename, 0, strpos($filename, '?'));

                $originalFile = $webDir . $tmp_dir . '/' . $filename;
                $destFile = $webDir . $files_dir . '/' . $filename;

                if (!file_exists($webDir . $files_dir)) {
                    mkdir($webDir . $files_dir, 0770, TRUE);
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

    /**
     * ContentManager constructor.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container);
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface|NULL $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @reference http://stackoverflow.com/a/10473026
     *
     * @param $haystack
     * @param $needle
     *
     * @return bool
     */
    private function endsWith($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
        return $needle === '' || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }

    /**
     * @reference http://stackoverflow.com/a/10473026
     *
     * @param $haystack
     * @param $needle
     *
     * @return bool
     */
    private function startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }



    // @todo Rethink logic for this (admin bundle)
    public function getContentEditRoute($id)
    {
        $em = $this->container->get('doctrine')->getManager();


        // @todo fix harcode route
        if (NULL !== $id) {
            $entity = $em->getRepository('IEPC\ContentBundle\Model\ContentInterface')
                ->find($id);
            $class = get_class($entity);

            $contents = $this->getContentTypes();
        }
        else {
            return 'iepc_website_admin_content_page';
        }

        return $contents[$class]['edit_route'];
    }

}