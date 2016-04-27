<?php namespace IEPC\WebsiteBundle\Controller;

use IEPC\WebsiteBundle\Form\Type\WebForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package IEPC\WebsiteBundle\Controller
 */
 class WebFormController extends Controller
{
    public function ParticipacionCiudadanaAction(Request $request)
    {
        if ($request->getMethod() == 'GET') {

            $form = $this->createForm(WebForm::class);

            return $this->render('IEPCWebsiteBundle:WebForm:participacionCiudadanaForm.html.twig', [
                'form' => $form->createView()
            ]);
        }
        else {
            $sentMessages = 0;

            $mensaje = [
                'nombre'  => $request->request->get('web_form')['name'],
                'email'   => $request->request->get('web_form')['email'],
                'asunto'  => $request->request->get('web_form')['subject'],
                'mensaje' => $request->request->get('web_form')['message']
            ];

            // Email to User
            $message = new \Swift_Message();
            $message->setSubject('Contacto web participación ciudadana - ' . $mensaje['asunto'])
                ->setFrom('noreply@iepcjalisco.org.mx', 'Web IEPC Jalisco')
                ->setTo('participacionciudadana@iepcjalisco.org.mx', 'Dirección de Participación Ciudadana')
                ->setReplyTo($mensaje['email'], $mensaje['nombre'])
                ->setBody(
                    $this->renderView('IEPCWebsiteBundle:WebForm:participacionCiudadana.html.twig', ['mensaje' => $mensaje]),
                    'text/html'
                )
                ->addPart(
                    $this->renderView('IEPCWebsiteBundle:WebForm:participacionCiudadana.txt.twig', ['mensaje' => $mensaje]),
                    'text/plain'
                );

            $sentMessages += $this->get('mailer')->send($message);

            $this->get('session')->getFlashBag()->add('pc_form', 'Tu mensaje ha sido enviado');

            return $this->redirect($request->headers->get('referer'));
        }
    }
}
