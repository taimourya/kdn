<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\Template;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class,[
                'label'=>'Nom de la template',
                'attr'=> ['placeholder' => 'Nom de la template']
                ])
            ->add('description', TextareaType::class,[
                'label'=>'description de la template',
                'attr'=> ['placeholder' => 'description de la template']
                ])
            ->add('preview_url', TextType::class,[
                'label'=>'Previsualisation Url',
                'attr'=> ['placeholder' => 'Previsualisation Url']
                ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'Name',
            
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('image', FileType::class, [
                'label' => false ,

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Template::class,
        ]);
    }
}
