<?php

namespace IEPC\DocumentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCDocumentBundle:Default:index.html.twig');
    }
}
