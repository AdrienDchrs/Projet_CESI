<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;

use Symfony\Component\Validator\Constraints as Assert;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr'          => [
                    'class'         => 'mt-2 block w-full shadow-sm sm:text-base border-black rounded-md bg-gray-100 p-2 focus:outline:none',
                    'id'            => 'title-input',
                    'name'          => 'title',
                    'minlength'     => '5',  
                    ],
                'constraints'   => [
                    new Assert\Length(['min' => 5]),
                    new Assert\NotBlank()
                ]
            ])
    
            ->add('texte', TextareaType::class, [
                'attr'          => [
                    'class'         => 'mt-2 block w-full shadow-sm sm:text-base border-black rounded-md bg-gray-100 p-2 focus:outline:none',
                    'minlength'     => '5', 
                    'id'            => 'text-input',
                    'name'          => 'content',
                    'rows'          => '3'
                    ],  
                'constraints'   => [
                    new Assert\Length(['min' => 5]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('imageFile', VichImageType::class, [
                'attr'          => [
                    'class'         => 'mt-2 block w-full shadow-sm sm:text-sm border-black rounded-md cursor-pointer bg-gray-100 mb-2'
                    ],
                'label'         => 'Image',
                'label_attr' => [
                    'class' => 'block text-base font-semibold text-black',
                    'for'   => 'image'
                ],
                'delete_label' => false,
                'download_uri' => false, 
                'allow_delete' => false
            ])

            ->add('submit', SubmitType::class, [
                'label'     => 'Ajouter une publication', 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
