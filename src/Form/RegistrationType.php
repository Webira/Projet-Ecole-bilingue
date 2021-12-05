<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\User;
use Doctrine\DBAL\Types\JsonArrayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, [
                "required"=>false,
                "label"=>'Mot de passe',
                'constraints' => [
                    new Length(['min'=> 8, 'max' => 4096]),
                ]
            ])
            ->add('confirm_password', PasswordType::class , [
                "required"=>false,
                "label"=>'Confirmation mot de passe',
            ])
           // ->add('roles', TextType::class)
            ->add('adress', TextType::class)
            ->add('phone', TextType::class)
            ->add('cp', TextType::class)
//            ->add('eleve', EntityType::class, [
//                "class"=>Eleve::class,
//                "choice_label"=>"nom",
//            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => "btn btn-secondary"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
