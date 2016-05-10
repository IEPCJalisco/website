<?php namespace IEPC\FilesBundle\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IEPC\FilesBundle\Entity\Document;

/**
 * @package IEPC\FilesBundle\Controller
 */
class DocumentController extends Controller
{
    /**
     * @param string $path
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderPathAction($path = '/')
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $document = $em->getRepository('IEPCFilesBundle:Document')->findByPath($path);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('La página no existe');
        } catch (NonUniqueResultException $e) {
            throw $this->createNotFoundException('Hay más de una página con la misma ruta');
        }

        return $this->RenderDocument($document);
    }

    /**
     * @param  Document $document
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RenderDocument(Document $document)
    {
        $layout = $document->getActiveLayout() ?: $this->getParameter('default_layout');
        $cm = $this->get('iepc.content_manager');
        $bundle = $cm->getBundleName($document->getContent());

        // @todo Rethink this ugliness (organize section layout in directories)
        $template = "{$bundle}:_webpage:{$layout}.html.twig";

        try {
            $response = $this->render($template, [
                'webpage' => $document
            ]);
        }
        catch (\InvalidArgumentException $e) {
            $response = $this->render($this->getParameter('default_webpage_layout'), [
                'webpage' => $document
            ]);
        }

        return $response;
    }
}
