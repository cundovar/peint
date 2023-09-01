<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Oeuvres;
use App\Entity\Categorie;
use App\Entity\OeuvreMatieres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class Oeuvres2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      
        $builder

            ->add('titre', TextType::class, [
                "label" => "Titre du produit*",
                "required" => false,
               
                "attr" => [
                    "placeholder" => "Saisir un titre",
                    "class" => "border border-danger bg-light",

                ],
                "label_attr" => [
                    "class" => "text-primary"
                ],
                "row_attr" => [
                    "id" => "titreBlock"
                ],

            ])
            ->add('prix', MoneyType::class,[
                "currency"=>"USD",
                "required"=>false,
                "label"=>"prix du produit*",
                "attr"=>[
                    "placeholder"=>"saisir un prix",
                    "class" => "border border-warning bg-light",
                ],
                "label_attr"=>["class"=> "text-success"]
            ])
            ->add('stock', IntegerType::class,[
                "required"=>false,
            ])
         
            ->add('categorie', EntityType::class, [
                "class" => Categorie::class,
                "choice_label" => "nom",
                "placeholder" => "Sélectionner une catégorie",
                "required" => false,
                "label" => "Catégorie*",
             
                //  "multiple" => true,
                //  "expanded" => true, // radio/checkbox

            ])

            ->add('description', TextareaType::class, [
                "help" => "Description facultative",
                "required" => false,
                "attr" => [
                    "rows" => 8,
                    "class" => "border border-info bg-light",
                    "style" => "margin:1rem"
                ],
                "label_attr" => [
                    "class" => "text-danger"
                ]
            ])
            ->add("matiere", EntityType::class, [
                "class" =>  Matiere::class,
                "choice_label" => "nom",
                "required" => false,
              
                "multiple" => true,
                "expanded" => true, // Affiche les checkboxes
                "label" => "Matière(s)*",
                "attr" => [
                    "class" => "col-12 mx-auto form-check "
                ],
                "label_attr"=>[
                    "class"=>"form-check-label"
                ], 
               
             
            
            ])

            ->add('dimention', TextareaType::class, [
                "help" => "facultatif",
                // "placeholder"=>"dimention en centimetre",
                "attr" => [
                    "rows" => 2,
                    "class" => "border border-info bg-light",
                    "style" => "margin:1rem"
                ]


            ]);

        if ($options['ajouter']) {
            $builder->add('image', FileType::class, [
                "required" => false,
                "data_class" => null,
                "attr" => [
                    'onchange' => "loadFile(event)"
                ]
            ]);
        }

        if ($options['modifier']) {
            $builder->add('imageUpdate', FileType::class, [
                "required" => false,
                "mapped" => false, // qui n'est pas dans l'entity
                "data_class" => null,
                "attr" => [
                    'onchange' => "loadFile(event)"
                ]
            ]);
        }
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Oeuvres::class,
            'ajouter' => false,
            'modifier' => false,
          
        ]);
    }
}
