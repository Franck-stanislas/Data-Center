<?php

namespace App\Form;

use App\Entity\EltMaturite;
use App\Entity\Maturite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EltMaturiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('idMaturite',EntityType::class,[
                'class' => Maturite::class,
                'mapped' => false,
                'placeholder' => 'Sélectionnez la maturité lié à l\'élément',
               'choice_label' => null,
                'multiple' => false,
                'expanded' => false,
                'choice_value' => function (?Maturite $entity) {
                    return $entity ? $entity->getNomMaturite() : '';
                },


            ])
//            ->add('id_maturite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EltMaturite::class,
        ]);
    }
}
