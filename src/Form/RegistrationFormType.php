<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'attr'=>["class"=>"inputRegister"]
            ] )
           
            ->add('prenom', TextType::class,[
                'attr'=>["class"=>"inputRegister"]
            ] )
            ->add('plainPassword', PasswordType::class, [
              
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                              "class"=>"inputRegister"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'mot de passe obligatoire',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'doit avoir 6 caractère minimum',
                    
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('Ok', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'vous êtes ok avec notre politique de confidentialité',
                    ]),
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
