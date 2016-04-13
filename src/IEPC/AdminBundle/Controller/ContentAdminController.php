<?php namespace IEPC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package IEPC\AdminBundle\Controller
 */
class ContentAdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCAdminBundle:Admin:index.html.twig');
    }
}