<?php namespace IEPC\AdminBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use IEPC\WebsiteBundle\Entity\Page;
use IEPC\WebsiteBundle\Form\Type\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package IEPC\AdminBundle\Controller
 */
class ContentController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contents = $em->getRepository('IEPC\ContentBundle\Model\ContentInterface')->findAll();

        $contenTypes = $this->get('iepc.content_manager')->getContentTypes();

        return $this->render('IEPCAdminBundle:Content:index.html.twig', [
            'contents' => $contents
        ]);
    }

//    public function editAction($id, Request $request)
//    {
//        $contentManager = $this->get('iepc.content_manager');
//
//        return $this->redirectToRoute($contentManager->getContentEditRoute($id), ['id' => $id]);
//    }

    public function editAction($id = null, Request $request)
    {
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
//        $form->handleRequest($request);

        if ($request->getRealMethod() == 'POST') {
            if (!isset($em)) {
                $em = $this->getDoctrine()->getManager();
            }

            $content = $request->request->get('content');
            $page->setContent($content);

            if ($id) {
                $em->persist($page);
                $em->flush();
            }

            //$cm = $this->get('iepc.content_manager');

            // Move _tmp to /web/content/page/id/file.ext
            //$page->setContent($cm->updateFileRoutes($page, $page->getContent()));
            //$cm->cleanOrphans($page, $page->getContent());

            //$em->persist($page);
            //$em->flush();

            return $this->redirectToRoute('iepc_content_admin_content');
        }

        return $this->render('@IEPCAdmin/Content/edit.html.twig', [
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
