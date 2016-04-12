<?php namespace IEPC\ContentAdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @package IEPC\ContentAdminBundle\Form\Type
 */
class SectionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'IEPC\ContentBundle\Entity\Section',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'required' => true
            ])
            ->add('path', TextType::class, [
                'label' => 'Path',
                'required' => true
            ])
            ->add('layout', TextType::class, [
                'label' => 'Layout',
                'required' => false
            ])
            ->add('parent', EntityType::class, [
                'class' => 'IEPC\ContentBundle\Entity\Section',
                'label' => 'Sección padre',
                'required' => true
            ])
            ->add('Guardar', SubmitType::class)
        ;
    }
}