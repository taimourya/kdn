<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CommandeStep3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('with_host', CheckboxType::class, [
                'label'    => 'avec hebergement + 1000 DH',
                'required' => false,
            ])
            ->add('with_maintenance', CheckboxType::class, [
                'label'    => 'avec 2 mois de maintenance + 1000 DH (sinon 2 semaine sont gratuite)',
                'required' => false,
            ])
            ->add('with_newsletter', CheckboxType::class, [
                'label'    => 'avec newsletter + 500 DH',
                'required' => false,
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
