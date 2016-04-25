<?php namespace IEPC\WebsiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @package IEPC\WebsiteBundle\Form\Type
 */
class WebForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true
            ])
            ->add('subject', TextType::class, [
                'label' => 'Asunto',
                'required' => true
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Mensaje',
                'required' => true
            ])
            ->add('Enviar', SubmitType::class)
        ;
    }
}