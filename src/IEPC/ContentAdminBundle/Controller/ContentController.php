<?php  namespace IEPC\ContentAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

class ContentController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $contents = $em->getRepository('IEPCContentBundle:Content')->findAll();

        return $this->render('IEPCContentAdminBundle:Content:index.html.twig', [
            'contents' => $contents
        ]);
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === ($content = $em->getRepository('IEPCContentBundle:Content')->find($id))){
            throw new NotFoundHttpException();
        }

        return $this->render('IEPCContentAdminBundle:Content:edit.html.twig', [
            'content' => $content
        ]);
    }

    public function saveAction($id = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === ($content = $em->getRepository('IEPCContentBundle:Content')->find($id))){
            throw new NotFoundHttpException();
        }

        $content->setContent($request->request->get('content'));

        $em->persist($content);
        $em->flush();

        return new JsonResponse(['status' => 'ok']);
    }
}