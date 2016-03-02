<?php  namespace IEPC\ContentAdminBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use IEPC\ContentBundle\Entity\Section;
use IEPC\ContentAdminBundle\Form\Type\SectionType;

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

        return $this->render('@IEPCContentAdmin/Section/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function getForm($section)
    {
        return $this->createForm(SectionType::class, $section, [
            'method' => 'POST'
        ]);
    }

}