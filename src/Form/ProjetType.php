<?php

namespace App\Form;

use App\Entity\Arrondissement;
use App\Entity\Categorie;
use App\Entity\Commune;
use App\Entity\Departement;
use App\Entity\Financement;
use App\Entity\Maturite;
use App\Entity\Projet;
use App\Entity\Region;
use App\Entity\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('region', EntityType::class, array(
                'mapped' => false,
                'class' => Region::class,
                'label' => "Region",
                'placeholder' => 'Sélectionnez votre région',
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm col-12'
                ],
                'auto_initialize' => false,

            ))
            ->add('institule')
            ->add('objectifs')
            ->add('resultats')
            ->add('couts')
            ->add('secteur', EntityType::class, array(
                'mapped' => false,
                'class' => Categorie::class,
                'label' => 'Categorie du projet',
                'choice_label' => 'nom_categorie',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm col-12'
                ],

            ))
            ->add('maturite', EntityType::class, array(
                'mapped' => false,
                'class' => Maturite::class,
                'label' => 'Maturité du projet',
                'choice_label' => 'nom_maturite',
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'justify-content-between form-control form-control-sm col-12'
                ],

            ))
            ->add('statut', EntityType::class, array(
                'mapped' => false,
                'class' => Statut::class,
                'label' => 'Statut du projet',
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-control form-control-sm col-12'
                ],

            ))
            ->add('financement', EntityType::class, array(
                'mapped' => false,
                'class' => Financement::class,
                'label' => 'Nature du financement',
                'choice_label' => 'nom_financement',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-control form-control-sm col-12'
                ],

            ))
        ;

        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $this->addDepartementField($form->getParent(), $form->getData());
            }
        );

    }

    private function addDepartementField(FormInterface $form, ?Region $region){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'departement',
            EntityType::class,
            null,
            [
                'class' => Departement::class,
                'placeholder' => $region ? 'Selectionnez votre departement' : 'Selectionnez votre region',
                'mapped' => false,
                'required' => true,
                'auto_initialize' => false,
                'choices' => $region ? $region->getDepartements() : []
            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $this->addArrondissementField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    private function addArrondissementField(FormInterface $form, ?Departement $departement){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'arrondissement',
            EntityType::class,
            null,
            [
                'class' => Arrondissement::class,
                'placeholder' => $departement ? 'Selectionnez votre arrondissement' : 'Selectionnez votre departement',
                'mapped' => false,
                'required' => true,
                'auto_initialize' => false,
                'choices' => $departement ? $departement->getArrondissements() : []
            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $this->addCommuneField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    private function addCommuneField(FormInterface $form, ?Arrondissement $arrondissement)
    {
        $form->add('commune', EntityType::class, [
            'class'       => Commune::class,
            'multiple' => true,
            'placeholder' => $arrondissement ? 'Sélectionnez votre commune' : 'Sélectionnez votre arrondissement',
            'choices'     => $arrondissement ? $arrondissement->getCommunes() : []
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
