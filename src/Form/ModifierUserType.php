<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints as Assert;

class ModifierUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('plainPassword', RepeatedType::class, [
            'type'          => PasswordType::class,
            'first_options' => [
                'attr'          => [
                    'class'       => 'w-full p-2 border rounded-md mb-2',
                    'placeholder' => '********'
                ],
                'label'     => 'Nouveau mot de passe : *', 
                'label_attr'    => ['class' => 'mb-2 text-[#F15508]']
            ],
            'second_options'=> [
                'attr'          => [
                    'class'     => 'w-full p-2 border rounded-md mb-2',
                    'placeholder'   => '*******' 
                ],
                'label'     => 'Confirmation du nouveau mot de passe : * ',
                'label_attr'    => ['class' => 'mb-2 text-[#F15508]',]
            ], 
            'attr'          => [
                'minlength'     => '2', 
                'maxlength'     => '255'
                ],
            'constraints'   => [
                new Assert\NotBlank()
            ]
        ])
    
        ->add('submit', SubmitType::class, [
            'label'     => 'Enregistrer', 
            'attr'      => ['class' => 'w-full bg-[#F15508] border border-[#F15508] rounded font-semibold text-white px-4 py-2 transition-transform transform hover:scale-105 focus:outline-none focus-visible:border-0 focus-visible:before:bg-transparent']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
