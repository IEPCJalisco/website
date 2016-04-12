<?php namespace IEPC\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ContentController extends Controller
{
    public function renderContentAction($contentName)
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $content = $em->getRepository('IEPC\ContentBundle\Model\ContentInterface')->findByName($contentName);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('El contenido no existe');
        } catch (NonUniqueResultException $e) {
            throw $this->createNotFoundException('Hay más de un contenido con el mismo nombre');
        }

        $contentManager = $this->get('iepc.content_manager');

        return new Response($contentManager->render($content));
    }
}
