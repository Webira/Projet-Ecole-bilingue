<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\User;
use PhpParser\Node\Name;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
//            ->add('date', DateType::class, [
//                'label' =>"Date d'inscription",
//                'attr'=>[
//                "format"=>"dd MM yyyy",
//                'placeholder'=>"Date d'inscription d'Eleve"]] )
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class, [
                'attr'=>["class"=>Name::class,"choice_label"=>"nom"]])
            ->add('birthdate', BirthdayType::class ,[
                'label' =>"Date de naissance",
                "widget"=>"choice",
                'years'=>range(1960, 2021),
                "format"=>"dd MM yyyy",
            ])
            ->add('age', TextType::class)
//            ->add('user', EntityType::class, [
//                "class"=>User::class,
//               "choice_label"=>"nom",
//               'placeholder'=>"Nom d'enfant = Nom du parent qui fait l'inscription",
//           ])
            ->add('cours', EntityType::class, [
                "class"=>Cours::class,
                "choice_label"=>"titre",
                "multiple"=>true,

            ])

            ->add("Valider", SubmitType::class,[
                'attr' => ['class' => "btn btn-warning"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
