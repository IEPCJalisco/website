<?php namespace IEPC\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller
{
    public function mainMenuAction()
    {
        return $this->render('IEPCWebsiteBundle:Menu:mainMenu.html.twig');
    }
}
