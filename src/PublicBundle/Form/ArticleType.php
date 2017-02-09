<?php

namespace PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('date', DateType::class,
                array(
                    'placeholder' => array(
                        'day' => 'Jour',
                        'month' => 'Mois',
                        'year' => 'Année',
                        ),
                    'format' => 'ddMMyyy',
                    )
                )
            ->add('category', EntityType::class,
                array(
                    'class' => 'PublicBundle:Category',
                    'choice_label' => 'name',
                  )
            )
            ->add('tags', EntityType::class,
                array(
                    'class' => 'PublicBundle:Tag',
                    'choice_label' => 'name',
                    'multiple' => true
                )
            )
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PublicBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'publicbundle_article';
    }


}
