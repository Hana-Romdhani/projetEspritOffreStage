<?php

namespace App\Form;

use App\Entity\Competence;
use App\Entity\Offre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomOffre', TextType::class, [
                'label' => 'Offer Name'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('datePublication', DateType::class, [
                'label' => 'Publication Date',
                'widget' => 'single_text'
            ])
            ->add('dateCloture', DateType::class, [
                'label' => 'Closing Date',
                'widget' => 'single_text'
            ])
            // ->add('competences', EntityType::class, [
            //     'class' => Competence::class,
            //     'choice_label' => 'nomCompetence',
            //     'multiple' => true,
            //     'expanded' => true,
            //     'label' => 'Competences'
            // ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
