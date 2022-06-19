<?php
namespace App\Form;

use App\Entity\SearchData;
use App\Entity\Categorie;
use App\Entity\Maturite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mot', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Mot clé'
                ]
            ])
            ->add('maturites', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                'class' => Maturite::class,
                'choice_label' => 'nom_maturite',
                'expanded' => true,
                'multiple' => true
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                'class' => Categorie::class,
                'choice_label' => 'nom_categorie',
                'expanded' => true,
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}