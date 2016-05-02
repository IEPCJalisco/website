<?php namespace IEPC\ContentBundle\Controller;

use IEPC\ContentBundle\Entity\WebPage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Twig_Error;

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
        $cm = $this->get('iepc.content_manager');
        $bundle = $cm->getBundleName($webPage->getContent());

        // @todo Rethink this ugliness (organize section layout in directories)
        $template = "{$bundle}:_webpage:{$layout}.html.twig";

        try {
            $response = $this->render($template, [
                'webpage' => $webPage
            ]);
        }
        catch (\InvalidArgumentException $e) {
            $response = $this->render($this->getParameter('default_webpage_layout'), [
                'webpage' => $webPage
            ]);
        }

        return $response;
    }
}
