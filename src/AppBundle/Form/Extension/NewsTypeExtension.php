<?php

namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Uppler\NewsBundle\Form\Type\NewsType;

class NewsTypeExtension extends AbstractTypeExtension
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'imageFile',
                Type\FileType::class,
                [
                    'label' => 'app.news.cover',
                ]
            )

            ->add(
                'submit',
                Type\SubmitType::class,
                [
                    'label' => 'app.news.publish',
                    'attr' => ['class' => 'waves-effect waves-light btn right blue'],
                ]
            )
        ;
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return NewsType::class;
    }
}
