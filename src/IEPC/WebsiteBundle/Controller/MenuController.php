<?php namespace IEPC\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
