<?php  namespace IEPC\AdminBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use IEPC\ContentBundle\Entity\Section;
use IEPC\ContentBundle\Form\Type\SectionType;

/**
 * @package IEPC\AdminBundle\Controller
 */
class SectionController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sections = $em->getRepository('IEPCContentBundle:Section')->findAll();

        return $this->render('IEPCAdminBundle:Section:index.html.twig', [
            'sections' => $sections
        ]);
    }

    public function editAction($id = null, Request $request)
    {
        if ($id !== null) {
            $em = $this->getDoctrine()->getManager();

            if (null === ($section = $em->getRepository('IEPCContentBundle:Section')->find($id))) {
                throw new EntityNotFoundException();
            };
        }
        else {
            $section = new Section();
        }

        $form = $this->getForm($section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!isset($em)) {
                $em = $this->getDoctrine()->getManager();
            }

            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute('iepc_content_admin_section');
        }

        return $this->render('@IEPCAdmin/Section/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === ($section = $em->getRepository('IEPCContentBundle:Section')->find($id))) {
            throw new EntityNotFoundException();
        };

        if ($section->getWebPages()->count() > 0) {
            throw new \Exception("Can't delete sections with webpages");
        }
        if ($section->getChildren()->count() > 0) {
            throw new \Exception("Can't delete sections with childrens");
        }

        $em->remove($section);
        $em->flush();

        return $this->redirectToRoute('iepc_content_admin_section');
    }

    private function getForm($section)
    {
        return $this->createForm(SectionType::class, $section, [
            'method' => 'POST'
        ]);
    }
}