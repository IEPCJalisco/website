<?php

namespace IEPC\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCContentBundle:Default:index.html.twig');
    }
}
