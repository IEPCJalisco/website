<?php namespace IEPC\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebPageController extends Controller
{
    public function indexAction($path)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('IEPCContentBundle:Page')->find($path);
        //@todo if not found the redirect to site search, replace the '/'s with spaces

        $page->getLayout();

        return $this->render('IEPCContentBundle:Default:index.html.twig', array(
            'content' => $page->getContent
        ));
    }
}
