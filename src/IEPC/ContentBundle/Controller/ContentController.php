<?php namespace IEPC\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use IEPC\ContentBundle\Model\ContentInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package IEPC\ContentBundle\Controller
 */
class ContentController extends Controller
{
    /**
     * @param $contentName
     * @param string $format
     * @param string $layout
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderByNameAction($contentName, $format = 'html', $layout = 'default')
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $content = $em->getRepository('IEPC\ContentBundle\Model\ContentInterface')->findByName($contentName);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('El contenido no existe');
        } catch (NonUniqueResultException $e) {
            throw $this->createNotFoundException('Hay más de un contenido con el mismo nombre');
        }

        $cm = $this->get('iepc.content_manager');

        return new Response($cm->render($content, $format, $layout));
    }

    /**
     * @param \IEPC\ContentBundle\Model\ContentInterface $content
     * @param string $format
     * @param string $layout
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RenderAction(ContentInterface $content, $format = 'html', $layout = 'default')
    {
        $cm = $this->get('iepc.content_manager');

        return new Response($cm->render($content, $format, $layout));
    }
}
