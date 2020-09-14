<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\Caracteristique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class,[
                'label'=>'Nom du service',
                'attr'=> ['placeholder' => 'Nom du service']
                ])
            ->add('description', TextareaType::class,[
                'label'=>'Description du service',
                'attr'=> ['placeholder' => 'Description du service']
                ])
            ->add('price', NumberType::class,[
                'label'=>'Prix du service',
                'attr'=> ['placeholder' => 'Prix du service']
                ])
            ->add('page_number', NumberType::class,[
                'label'=>'Nombre de page fourni',
                'attr'=> ['placeholder' => 'Nombre de page fourni']
                ])
            ->add('caracteristiques', EntityType::class, [
                    'class' => Caracteristique::class,
                
                    'choice_label' => 'libele',
                
                    'multiple' => true,
                    'expanded' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
