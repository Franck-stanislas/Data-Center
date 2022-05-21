<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_categorie')
//            ->add('imageName')
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image (JPG | PNG | SVG file)',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => '...',
                'download_uri' => false,
                'imagine_pattern' => 'squared_thumbnail_medium'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
