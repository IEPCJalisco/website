<?php namespace IEPC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package IEPC\AdminBundle\Controller
 */
class MenuController extends Controller
{
    public function adminAction()
    {
        return $this->render('IEPCAdminBundle:Menu:admin.html.twig');
    }
}
