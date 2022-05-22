<?php
namespace App\Form;

use App\Entity\PiezaMuseo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

//Solo se puede usar en las actualizaciones:
//So far, this works great, but only to edit existing tags. It doesn't allow us yet to add new tags or delete existing ones.
class PiezaMuseoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('titulo', TextType::class, [
            'required' => true,
            'constraints' => [
            new NotBlank([
                'message' => 'Introduzca el título',
            ])
            ]
            ])
        ->add('descripcion', TextareaType::class,[
            'required' => true,
            'constraints' => [
            new NotBlank([
                'message' => 'Introduzca una breve descripción',
            ])
            ]
        ])
        ->add('epoca', TextType::class,[
            'required' => true,
            'constraints' => [
            new NotBlank([
                'message' => 'Introduzca la época',
            ])
            ]
        ])
        ->add('imagen', FileType::class,[
            'required' => true,
            'constraints' => [
            new NotBlank([
                'message' => 'Tiene que añadir una imagen',
            ])
            ]
        ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PiezaMuseo::class,
        ]);
    }
}