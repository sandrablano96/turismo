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

class RegistrationFormType extends AbstractType
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
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Acepto los términos  ', 
                'attr' => ['class' => 'm-2'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Debes aceptar los términos',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Contraseña',
                'attr' => ['autocomplete' => 'new-password'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Introduzca la contraseña',
                    ]),
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
