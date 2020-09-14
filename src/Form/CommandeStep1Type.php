<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class CommandeStep1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client_lastname', TextType::class,[
                'label'=>'Nom',
                'attr'=> ['placeholder' => 'Nom']
                ])
            ->add('client_firstname', TextType::class,[
                'label'=>'Prenom',
                'attr'=> ['placeholder' => 'Prenom']
                ])
            ->add('email', EmailType::class,[
                'label'=>'Email',
                'attr'=> ['placeholder' => 'Example@Domaine.com']
                ])
            ->add('phone', TextType::class,[
                'label'=>'Numéro de Téléphone',
                'attr'=> ['placeholder' => '+212XXXXXXXXX']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
