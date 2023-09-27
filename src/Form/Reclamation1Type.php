<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Reclamation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user',TextType::class,[
                'label'=>'userEmail',
                'disabled' => true,
            ])
            ->add('dateReclamation', DateType::class, [
                'label' => 'Date Reclamation',
                'disabled' => true,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'dateReclamation' // add an id attribute
                ]
            ])
            ->add('description',TextareaType::class)
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Pending' => 'pending',
                    'In Progress' => 'in progress',
                    'Resolved' => 'resolved'
                ],             
                   'data' => 'pending',

            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
