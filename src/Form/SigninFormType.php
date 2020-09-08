<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\IsValidPassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Defines the custom form field type to sign in.
 */
class SigninFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Votre identifiant est trop court (minimum {{ limit }} caractères)',
                        'max' => 30,
                        'maxMessage' => 'Votre identifiant est trop long (maximum {{ limit }} caractères)',
                    ]),
                ],
                'attr' => ['autofocus' => true],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci d\'entrer un mot de passe',
                        ]),
                        new IsValidPassword(),
                    ],
                ],
                'invalid_message' => 'Les mots de passe ne sont pas identiques.',
                'mapped' => false,
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un email',
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
