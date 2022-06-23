<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\VichUploaderBundle;

class AddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un e-mail',
                    ]),
                ],
                'required' => true,
                'label' => false,
            ])
            ->add('roles',ChoiceType::class, [
                'choices' => [
                    'Utilisateur communale' => 'ROLE_ADMIN',
                    'Administrateur' => 'ROLE_SUPER_ADMIN'
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('password', TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer votre mot de passe',
                    ]),
                ],
                'required' => true,
                'label' => false,
            ])
            ->add('firstName', TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer votre nom',
                    ]),
                ],
                'required' => true,
                'label' => false,
            ])
            ->add('lastName', TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer votre prenom',
                    ]),
                ],
                'required' => true,
                'label' => false,
            ])
            ->add('phone', NumberType::class,[
                'label' => false
            ])
            ->add('image', VichImageType::class,[
                'label' =>  false,
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer?',
                'download_uri' => false,
                'imagine_pattern' => 'squared_thumbnail_medium'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
