<?php

namespace App\Application\Blog\Form;

use App\Application\Blog\DTO\CommentDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'authorName',
                TextType::class,
                [
                    'label' => 'Your Name',
                    'attr'  => ['class' => 'form-control'],
                ])
            ->add(
                'authorEmail',
                TextType::class,
                [
                    'label' => 'Your Email',
                    'attr'  => ['class' => 'form-control'],
                ])
            ->add(
                'content',
                TextareaType::class,
                [
                    'label' => 'Your Comment',
                    'attr'  => ['class' => 'form-control'],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => CommentDTO::class,
                               ]);
    }
}
