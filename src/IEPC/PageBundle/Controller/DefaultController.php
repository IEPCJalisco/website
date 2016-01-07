<?php

namespace IEPC\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCPageBundle:Default:index.html.twig');
    }
}
