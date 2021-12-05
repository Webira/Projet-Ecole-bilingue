<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Professor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Polyfill\Intl\Icu\DateFormat\DayOfWeekTransformer;
use Symfony\Polyfill\Intl\Icu\DateFormat\DayTransformer;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       if($options['add']==true):
        $builder
            ->add('titre', TextType::class)
            ->add('day', TextType::class)
            ->add('duree', TextType::class)
            ->add('age', TextType::class)
            ->add('price', TextType::class)
            ->add('class', TextType::class)
            /*->add('eleve', EntityType::class, [
                'class'=> Eleve::class,
                'choice_label' => 'nom'
                "multiple"=> true,
            ])
                */
            ->add('description', TextareaType::class)
            ->add('professor', EntityType::class, [
                'class'=> Professor::class,
                'choice_label' => 'nom',
            ])
            ->add('photo', FileType::class, [
                "required" => false
            ])

            ->add("Ajouter", SubmitType::class,[
                'attr' => ['class' => "btn btn-warning"]]);

            elseif ($options['modif']==true):

                $builder
                    ->add('titre', TextType::class)
                    ->add('day', TextType::class)
                    ->add('duree', TextType::class)
                    ->add('age', TextType::class)
                    ->add('price', TextType::class)
                    ->add('class', TextType::class)
//                    ->add('eleve', EntityType::class, [
//                        'class'=> Eleve::class,
//                        'choice_label' => 'nom',
//                        'multiple' => true,
//                    ])

                    ->add('description', TextareaType::class)
                    ->add('professor', EntityType::class, [
                        'class'=> Professor::class,
                        'choice_label' => 'nom',
                    ])
                    ->add('photoFile', FileType::class, [
                        "required" => false,
                        "mapped" => false
                    ])

                    // ->add("Valider", FileType::class, array('data_class'=> null))
                    ->add("Modifier", SubmitType::class, [
                            'attr' => ['class' => "btn btn-warning"]
                        ]);

                endif;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
            'add'=>false,
            'modif' =>false ]);
    }
}
