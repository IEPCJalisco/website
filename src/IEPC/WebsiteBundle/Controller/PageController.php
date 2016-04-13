<?php namespace IEPC\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IEPC\WebsiteBundle\Entity\Page;
use Doctrine\ORM\EntityNotFoundException;
use IEPC\WebsiteBundle\Form\Type\PageType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package IEPC\WebsiteBundle\Controller
 */
class PageController extends Controller
{
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
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!isset($em)) {
                $em = $this->getDoctrine()->getManager();
            }

            if (!$id) {
                $em->persist($page);
                $em->flush();
            }

            $cm = $this->get('iepc.content_manager');

            // Move _tmp to /web/content/page/id/file.ext
            $page->setContent($cm->updateFileRoutes($page, $page->getContent()));
            $cm->cleanOrphans($page, $page->getContent());

            $em->persist($page);
            $em->flush();

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
