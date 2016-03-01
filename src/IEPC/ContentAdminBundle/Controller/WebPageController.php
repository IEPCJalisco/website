<?php  namespace IEPC\ContentAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WebPageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $webpages = $em->getRepository('IEPCContentBundle:WebPage')->findAll();

        return $this->render('IEPCContentAdminBundle:WebPage:index.html.twig', [
            'webpages' => $webpages
        ]);
    }

    public function editAction($id)
    {

    }

    public function saveAction($id = null, Request $request)
    {

    }
}