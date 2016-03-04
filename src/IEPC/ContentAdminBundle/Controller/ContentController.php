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

        $ct = $this->get('iepc.content_manager')->getContentTypes();

        $contents = $em->getRepository('IEPCContentBundle:Content')->findAll();

        return $this->render('IEPCContentAdminBundle:Content:index.html.twig', [
            'contents' => $contents
        ]);
    }

    public function editAction($id = null, Request $request)
    {
        //@TODO Use content manager

        if ($id !== null) {
            $em = $this->getDoctrine()->getManager();

            if (null === ($page = $em->getRepository('IEPCWebsiteBundle:Page')->find($id))) {
                throw new EntityNotFoundException();
            };
        }
        else {
            $page = new Page();
        }

        $form = $this->getForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!isset($em)) {
                $em = $this->getDoctrine()->getManager();
            }

            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('iepc_content_admin_content');
        }

        return $this->render('@IEPCContentAdmin/Content/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function getForm($section)
    {
        return $this->createForm(PageType::class, $section, [
            'method' => 'POST'
        ]);
    }
}
