<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Matiere;
use App\filter\OeuvreFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OeuvreFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add("recherche", TextType::class, [
            "required" => false,
            "label" => false,
            "attr" => [
                "placeholder" => "recherche",
                "class" => "form-control"
            ],
            "row_attr" => [
                "class" => "form-group"
            ]
        ])
        ->add("min", MoneyType::class, [
            "required" => false,
            "label" => false,
            "attr" => [
                "placeholder" => "prix minimum",
                "class" => "form-control"
            ],
            "row_attr" => [
                "class" => "form-group"
            ]
        ])
        ->add("max", MoneyType::class, [
            "required" => false,
            "label" => false,
            "attr" => [
                "placeholder" => "prix maximun",
                "class" => "form-control"
            ],
            "row_attr" => [
                "class" => "form-group"
            ]
        ])
        ->add("order", ChoiceType::class, [
            "required" => false,
            "label" => "ordre des oeuvres",
            "choices" => [
                "croissant/décroisant"=>"",
                "prix croissant" => 0,
               
                "prix décroissant" => 1,
            ],
            "attr" => [
                "placeholder"=>"ordre",
                "class" => "form-control"
            ],
            "row_attr" => [
                
                "class" => "form-group orderCata"
            ]
        ])
        ->add("categories", EntityType::class, [
            "class" => Categorie::class,
            "choice_label" => "nom",
            "attr"=> [
                "class"=>"form-check"
            ],
            "multiple" => true,
            "expanded" => true,
            "required" => false,
            "row_attr" => [
                "class" => "form-check-input",
               
            ],
            
            "row_attr" => [
                "class" => "form-group ligneCata"
            ]
        ])
        ->add("matieres", EntityType::class, [
            "class" => Matiere::class,
            "choice_label" => "nom",
            "multiple" => true,
            "expanded" => true,
            "required" => false,
            "attr" => [
                "class" => "form-check"
            ],
            "row_attr" => [
                "class" => "form-group"
            ]
        ])
       ;
            }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            "data_class"=>OeuvreFilter::class
        ]);
    }
}