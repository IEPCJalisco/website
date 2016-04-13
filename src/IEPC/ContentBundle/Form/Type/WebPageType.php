<?php namespace IEPC\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @package IEPC\AdminBundle\Form\Type
 */
class WebPageType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'IEPC\ContentBundle\Entity\WebPage',
        ]);
    }

    // @TODO Remove hardocded Content reference
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', TextType::class, [
                'label' => 'Path',
                'required' => false
            ])
            ->add('showOnMenu', CheckboxType::class, [
                'label' => 'Mostrar en menús',
                'required' => false
            ])
            ->add('layout', TextType::class, [
                'label' => 'Layout',
                'required' => false
            ])
            ->add('section', EntityType::class, [
                'class' => 'IEPC\ContentBundle\Entity\Section',
                'label' => 'Sección',
                'required' => true
            ])
            ->add('content', EntityType::class, [
                'class' => 'IEPC\WebsiteBundle\Entity\Content',
                'label' => 'Contenido',
                'choice_label' => 'name',
                'required' => true
            ])
            ->add('parent', EntityType::class, [
                'class'       => 'IEPC\ContentBundle\Entity\WebPage',
                'label'       => 'Página padre',
                'empty_data'  => null,
                'placeholder' => '-----',
                'required'    => false
            ])
            ->add('Guardar', SubmitType::class)
        ;
    }
}