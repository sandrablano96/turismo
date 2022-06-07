<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateUserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca el email',
                    ])
            ],
            ])
            ->add('nombre', TextType::class,  [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca su nombre',
                    ])
            ],
            ])
            ->add('apellidos', TextType::class,  [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca sus apellidos',
                    ])
            ],
            ])
            ->add('localidad', TextType::class,  [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca su localidad de origen',
                    ])
            ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Contraseña',
                'attr' => ['autocomplete' => 'new-password'],
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'minMessage' => 'La contraseña debe tener al menos 6 carácteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
