<?php namespace IEPC\SesionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCSesionBundle:Default:index.html.twig');
    }
}
