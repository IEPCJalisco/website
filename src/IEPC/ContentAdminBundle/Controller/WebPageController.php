<?php  namespace IEPC\ContentAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use IEPC\ContentBundle\Entity\WebPage;
use IEPC\ContentAdminBundle\Form\Type\WebPageType;

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

    public function editAction($id = null, Request $request)
    {
        if ($id !== null) {
            $em = $this->getDoctrine()->getManager();

            if (null === ($webpage = $em->getRepository('IEPCContentBundle:WebPage')->find($id))) {
                throw new EntityNotFoundException();
            };
        }
        else {
            $webpage = new WebPage();
        }

        $form = $this->getForm($webpage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!isset($em)) {
                $em = $this->getDoctrine()->getManager();
            }

            $em->persist($webpage);
            $em->flush();

            return $this->redirectToRoute('iepc_content_admin_webpage');
        }

        return $this->render('@IEPCContentAdmin/WebPage/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === ($webPage = $em->getRepository('IEPCContentBundle:WebPage')->find($id))) {
            throw new EntityNotFoundException();
        };

        if ($webPage->getChildren()->count() > 0) {
            throw new \Exception("Can't delete webpages with childrens");
        }

        $em->remove($webPage);
        $em->flush();

        return $this->redirectToRoute('iepc_content_admin_webpage');
    }

    private function getForm($webpage)
    {
        return $this->createForm(WebPageType::class, $webpage, [
            'method' => 'POST'
        ]);
    }
}