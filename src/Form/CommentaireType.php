<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', TextareaType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "rows" => 5,
                    "cols"=>50,
                    "class" => "border border-info bg-light",
                    // "placeholder" => "Laisser votre avis..."
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous pouvez écrire un avis',
                    ]),
                ],
            ])
            // ->add('envoyer',SubmitType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
