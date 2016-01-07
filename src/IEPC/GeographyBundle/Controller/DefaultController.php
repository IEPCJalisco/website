<?php namespace IEPC\GeographyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCGeographyBundle:Default:index.html.twig');
    }
}
