<?php

namespace IEPC\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCSecurityBundle:Default:index.html.twig');
    }
}
