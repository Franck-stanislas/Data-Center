<?php

namespace App\Form;

use App\Entity\Maturite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaturiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_maturite', TextType::class,[
                'label'=> false,
                'attr' => [
                    'class' => 'form-control form-control-sm col-12',
                    'placeholder' => "Entrer le nom de la maturité"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maturite::class,
        ]);
    }
}
