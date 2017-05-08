<?php

namespace Uppler\CommentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'content',
                Type\TextareaType::class,
                [
                    'label' => false,
                    'attr' => ['placeholder' => 'uppler.comment.content'],
                    'label_attr' => ['class' => 'active'],
                ]
            )
            ->add(
                'submit',
                Type\SubmitType::class,
                [
                    'label' => 'uppler.comment.publish',
                    'attr' => ['class' => 'waves-effect waves-light btn right blue submit-comment'],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Uppler\\CommentBundle\\Model\\CommentInterface',
        ]);
    }
}
