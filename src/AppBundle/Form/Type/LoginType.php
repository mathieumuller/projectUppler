<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                '_username',
                Type\TextType::class,
                [
                    'label' => 'authentication.username',
                    'data' => $options['last_username'],
                    'label_attr' => ['class' => 'active'],
                ]
            )
            ->add(
                '_password',
                Type\PasswordType::class,
                [
                    'label' => 'authentication.password',
                    'label_attr' => ['class' => 'active'],
                ]
            )
            ->add(
                '_submit',
                Type\SubmitType::class,
                [
                    'label' => 'authentication.login',
                    'attr' => ['class' => 'btn btn-success right'],
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'last_username' => null,
            'intention' => 'authenticate',
        ]);
    }

    public function getBlockPrefix()
    {
        return;
    }
}
