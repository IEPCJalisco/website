<?php namespace IEPC\ContentAdminBundle\Controller;

use IEPC\WebsiteBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use IEPC\WebsiteBundle\Form\Type\PageType;
use Doctrine\ORM\EntityNotFoundException;

class ContentController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contents = $em->getRepository('IEPCWebsiteBundle:Content')->findAll();

        return $this->render('IEPCContentAdminBundle:Content:index.html.twig', [
            'contents' => $contents
        ]);
    }

    public function editAction($id)
    {
        $contentManager = $this->get('iepc.content_manager');

        return $this->redirectToRoute($contentManager->getContentEditRoute($id), ['id' => $id]);
    }
}
