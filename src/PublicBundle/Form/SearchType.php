<?php

namespace PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchName', TextType::class, array(
              'label' => "Recherche par nom d'article",
              'required' => false
            ))
            ->add('searchTag', TextType::class, array(
              'label' => "Recherche par tag",
              'required' => false
            ))
            ->add('send', SubmitType::class, array(
              'label' => "Rechercher"
            ))
        ;
    }



}
