<?php  namespace IEPC\ContentAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContentAdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('IEPCContentAdminBundle:ContentAdmin:index.html.twig');
    }
}