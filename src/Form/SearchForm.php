<?php
namespace App\Form;

use App\Entity\SearchData;
use App\Entity\Categorie;
use App\Entity\Maturite;
use Doctrine\ORM\EntityRepository;
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
                'required' => true,
                'attr' => [
                    'placeholder' => 'Mot clé',
                ]
            ])
            ->add('maturites', EntityType::class, [
                'class' => Maturite::class,
//                'mapped' => false,
                'placeholder' =>'Choisir Maturité',
                'choice_label' => 'nom_maturite',
                'required' => false,
                'expanded' => false,
                'multiple' => false,
//                'choice_value' => function (?Maturite $entity) {
//                    return $entity ? $entity->getNomMaturite() : '';
//                },

            ])
            ->add('categories', EntityType::class, [
                'label' => false,
//                'mapped' => false,
                'required' => false,
                'class' => Categorie::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom_categorie', 'ASC');
                },
                'choice_label' => 'nom_categorie',
                'placeholder' =>'Choisir categorie',
                'expanded' => false,
                'multiple' => false
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