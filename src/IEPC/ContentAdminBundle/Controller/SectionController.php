<?php  namespace IEPC\ContentAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SectionController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sections = $em->getRepository('IEPCContentBundle:Section')->findAll();

        return $this->render('IEPCContentAdminBundle:Section:index.html.twig', [
            'sections' => $sections
        ]);
    }

    public function editAction($id)
    {

    }

    public function saveAction($id = null, Request $request)
    {

    }
}