<?php namespace IEPC\FilesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCFilesBundle:Default:index.html.twig');
    }
}
