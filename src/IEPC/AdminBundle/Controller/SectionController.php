<?php  namespace IEPC\AdminBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use IEPC\ContentBundle\Entity\Section;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
//        if ($id !== null) {
//            $em = $this->getDoctrine()->getManager();
//
//            if (null === ($section = $em->getRepository('IEPCContentBundle:Section')->find($id))) {
//                throw new EntityNotFoundException();
//            };
//        }
//        else {
//            $section = new Section();
//        }
//
//        $form = $this->getForm($section);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            if (!isset($em)) {
//                $em = $this->getDoctrine()->getManager();
//            }
//
//            $em->persist($section);
//            $em->flush();
//
//            return $this->redirectToRoute('iepc_content_admin_section');
//        }

        return $this->render('@IEPCAdmin/Section/edit.html.twig');
    }

    public function deleteAction1($id)
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

    /** API **/
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('serializer');
        $normalizer = $this->get('get_set_method_normalizer');

        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getName();
        });

        $sections = $em->getRepository('IEPCContentBundle:Section')->findAll();

        $response = new Response();
        $response->setContent($serializer->serialize($sections, 'json'));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function putAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$section = $em->getRepository('IEPCContentBundle:Section')->find($id)) {
            throw new NotFoundHttpException();
        }
    }

    public function postAction()
    {
        $em = $this->getDoctrine()->getManager();

        $section = new Section();
    }

    public function deleteAction($id)
    {

    }
}