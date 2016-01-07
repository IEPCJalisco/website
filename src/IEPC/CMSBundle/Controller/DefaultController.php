<?php

namespace IEPC\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCCMSBundle:Default:index.html.twig');
    }
}
