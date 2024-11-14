<?php

namespace App\Application\User\Form;

use App\Application\User\DTO\AuthorDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuthorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label'    => 'Name',
                    'required' => true,
                    'attr'     => ['class' => 'form-control'],
                ])
            ->add('email',
                  TextType::class, [
                      'label'    => 'Email',
                      'required' => true,
                      'attr'     => ['class' => 'form-control'],
                  ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => AuthorDTO::class,
                               ]);
    }
}
