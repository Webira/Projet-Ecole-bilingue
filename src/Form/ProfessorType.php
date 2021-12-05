<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Professor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('description', TextType::class)

//            ->add('cours', TextType::class)
//                [
//                'class'=>  Cours::class,
//               "choice_label" => "titre",
//                "multiple"=> true,
//            ])

            ->add("Valider", SubmitType::class,[
            'attr' => ['class' => "btn btn-warning"]
        ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Professor::class,
            'add'=>false,
            'modif' =>false
        ]);
    }
}
