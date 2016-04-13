<?php namespace IEPC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package IEPC\AdminBundle\Controller
 */
class ContentController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contents = $em->getRepository('IEPC\ContentBundle\Model\ContentInterface')->findAll();

        return $this->render('IEPCAdminBundle:Content:index.html.twig', [
            'contents' => $contents
        ]);
    }

    public function editAction($id)
    {
        $contentManager = $this->get('iepc.content_manager');

        return $this->redirectToRoute($contentManager->getContentEditRoute($id), ['id' => $id]);
    }
}
