<?php namespace IEPC\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package IEPC\WebsiteBundle\Controller
 */
class MenuController extends Controller
{
    public function mainAction()
    {
        return $this->render('IEPCWebsiteBundle:Menu:main.html.twig');
    }

    public function participacionCiudadanaAction()
    {
        return $this->render('IEPCWebsiteBundle:Menu:participacion-ciudadana.html.twig');
    }

    public function transparenciaAction()
    {
        return $this->render('IEPCWebsiteBundle:Menu:transparencia.html.twig');
    }
}
