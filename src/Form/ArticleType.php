<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre de votre article',
                ],
            ]);

        if ($options['isEdit']) {
            $builder
                ->add('user', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'fullName',
                    'expanded' => false,
                    'multiple' => false,
                ]);
        }

        $builder->add('content', TextareaType::class, [
            'label' => 'Contenu',
            'attr' => [
                'placeholder' => 'Contenu de votre article',
                'rows' => 5,
            ],
        ])
            ->add('enable', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'sanitize_html' => true,
            'isEdit' => false,
        ]);
    }
}
