<?php namespace IEPC\ContentBundle\Controller;

use IEPC\ContentBundle\Entity\WebPage;
use IEPC\ContentBundle\Model\ContentInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @package IEPC\ContentBundle\Controller
 */
class WebPageController extends Controller
{
    /**
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderPathAction($path = '/')
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $webPage = $em->getRepository('IEPCContentBundle:WebPage')->findByPath($path);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('La página no existe');
        } catch (NonUniqueResultException $e) {
            throw $this->createNotFoundException('Hay más de una página con la misma ruta');
        }

        return $this->RenderWebPage($webPage);
    }

    /**
     * @param \IEPC\ContentBundle\Entity\WebPage $webPage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RenderWebPage(WebPage $webPage)
    {
        $layout = $webPage->getActiveLayout() ?: $this->getParameter('default_layout');
        $bundle = $this->getBundleNameFromEntity(get_class($webPage->getContent()), $this->get('kernel')->getBundles());

        $template = "{$bundle}:_webpage:{$layout}.html.twig";

        return $this->render($template, [
            'webpage' => $webPage
        ]);
    }

    /**
     * @param \IEPC\ContentBundle\Model\ContentInterface $content
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @todo move to ContentController and merge with current implementation
     */
    public function RenderContentAction(ContentInterface $content)
    {
        $bundle = $this->getBundleNameFromEntity(get_class($content), $this->get('kernel')->getBundles());

        $template = "{$bundle}:_content/page:default.html.twig";

        return $this->render($template, [
            'content' => $content
        ]);
    }


    // @todo put this in a service
    protected static function getBundleNameFromEntity($entityNamespace, $bundles)
    {
        $dataBaseNamespace = substr($entityNamespace, 0, strpos($entityNamespace, '\\Entity\\'));

        foreach ($bundles as $type => $bundle) {
            $bundleRefClass = new \ReflectionClass($bundle);
            if ($bundleRefClass->getNamespaceName() === $dataBaseNamespace) {
                return $type;
            }
        }

        return null;
    }
}
