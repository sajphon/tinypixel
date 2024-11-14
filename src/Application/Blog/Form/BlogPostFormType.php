<?php

namespace App\Application\Blog\Form;

use App\Domain\User\Model\Author;
use Symfony\Component\Form\AbstractType;
use App\Application\Blog\DTO\BlogPostDTO;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BlogPostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label'    => 'Title',
                    'required' => true,
                    'attr'     => ['class' => 'form-control'],
                ])
            ->add(
                'description',
                TextareaType::class,
                [
                    'label'    => 'Description',
                    'required' => true,
                    'attr'     => ['class' => 'form-control'],
                ])
            ->add(
                'content',
                TextareaType::class,
                [
                    'label'    => 'Content',
                    'required' => true,
                    'attr'     => ['class' => 'form-control'],
                ])
            ->add(
                'author',
                EntityType::class,
                [
                    'label'         => 'Author',
                    'class'         => Author::class,
                    'choice_label'  => 'name',
                    'choice_value'  => 'uuid',
                    'placeholder'   => 'Select an author',
                    'attr'          => ['class' => 'form-control'],
                    'query_builder' => function ($repo) {
                        return $repo->createQueryBuilder('a')->orderBy('a.name', 'ASC');
                    },
                ]);

        //$builder->get('authorUuid')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => BlogPostDTO::class,
                               ]);
    }
}
