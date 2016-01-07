<?php namespace IEPC\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebsiteController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCWebsiteBundle:Website:index.html.twig');
    }
}
