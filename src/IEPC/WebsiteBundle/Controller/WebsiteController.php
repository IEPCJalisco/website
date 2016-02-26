<?php namespace IEPC\WebsiteBundle\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebsiteController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCWebsiteBundle:Website:index.html.twig');
    }

    public function contentAction($path) {
        $em = $this->getDoctrine()->getManager();

        try {
            $webPage = $em->getRepository('IEPCContentBundle:WebPage')
                ->findByPath($path);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('La página no existe');
        } catch (NonUniqueResultException $e) {
            throw $this->createNotFoundException('Hay más de una página con la misma ruta');
        }

        return $this->render('IEPCWebsiteBundle:Website:index.html.twig');
    }
}
