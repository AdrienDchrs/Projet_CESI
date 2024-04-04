<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr'          => [
                    'class'         => 'w-full p-2 border rounded-md mb-2',
                    'minlength'     => '3', 
                    'maxlength'     => '50',
                    'placeholder'   => 'Decharrois' 
                    ],
                'constraints'   => [
                    new Assert\Length(['min' => 3, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('prenom', TextType::class, [
                'attr'          => [
                    'class'         => 'w-full p-2 border rounded-md mb-2',
                    'minlength'     => '3', 
                    'maxlength'     => '50',
                    'placeholder'   => 'Adrien' 
                    ],
                'constraints'   => [
                    new Assert\Length(['min' => 3, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('email', EmailType::class, [
                'attr'          => [
                    'class'         => 'w-full p-2 border rounded-md mb-2',
                    'minlength'     => '2', 
                    'maxlength'     => '255',
                    'placeholder'   => 'exemple@gmail.com' 
                    ],
                'constraints'   => [
                    new Assert\Length(['max' => 255]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('plainPassword', RepeatedType::class, [
                'type'          => PasswordType::class,
                'first_options' => [
                    'attr'          => [
                        'class'       => 'w-full p-2 border rounded-md mb-2',
                        'placeholder' => '*******'
                    ],
                    'label'     => 'Mot de passe : *', 
                    'label_attr'    => ['class' => 'mb-2 text-[#F15508]'],
                ],
                'second_options'=> [
                    'attr'          => [
                        'class'     => 'w-full p-2 border rounded-md mb-2',
                        'placeholder' => '*******'
                    ],
                    'label'     => 'Confirmation du mot de passe : * ',
                    'label_attr'    => ['class' => 'mb-2 text-[#F15508]'],
                ], 
                'attr'          => [
                    'class'         => 'w-full p-2 border rounded-md mb-2',
                    'minlength'     => '2', 
                    'maxlength'     => '255',
                    'placeholder'   => '*******' 
                    ],
                'constraints'   => [
                    new Assert\Length(['min' => 8, 'max' => 255]),
                    new Assert\NotBlank()
                ], 
                'invalid_message' => 'Les mots de passes ne correspondent pas.'
            ])

            ->add('submit', SubmitType::class, [
                'label'     => 'S\'inscrire', 
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
