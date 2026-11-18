<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

final class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('displayName', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'autocomplete' => 'name',
                    'placeholder' => 'Vor- und Nachname',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-Mail',
                'attr' => [
                    'autocomplete' => 'email',
                    'placeholder' => 'du@beispiel.de',
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Passwort',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'second_options' => [
                    'label' => 'Passwort wiederholen',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'invalid_message' => 'Die Passwörter stimmen nicht überein.',
                'constraints' => [
                    new Assert\NotBlank(message: 'Bitte wähle ein Passwort.'),
                    new Assert\Length(
                        min: 8,
                        max: 4096,
                        minMessage: 'Das Passwort muss mindestens {{ limit }} Zeichen lang sein.',
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
