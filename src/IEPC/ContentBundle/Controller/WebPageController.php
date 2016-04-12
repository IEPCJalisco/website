<?php namespace IEPC\ContentBundle\Controller;

use IEPC\ContentBundle\Entity\WebPage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @package IEPC\ContentBundle\Controller
 */
class WebPageController extends Controller
{
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

    public function RenderWebPage(WebPage $webPage)
    {
        $layout = $webPage->getActiveLayout() ?: $this->getParameter('default_layout');

        return $this->render('IEPCContentBundle:WebPage:index.html.twig', [
            'webpage' => $webPage,
            'layout'  => $layout
        ]);
    }
}
