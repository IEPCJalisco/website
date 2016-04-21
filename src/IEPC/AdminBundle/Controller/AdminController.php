<?php namespace IEPC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package IEPC\AdminBundle\Controller
 */
class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCAdminBundle:Admin:index.html.twig');
    }

    public function mainAction()
    {
        return $this->render('IEPCAdminBundle:Admin:main.html.twig');
    }
}