<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Reponse;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user',TextType::class,[
                'label'=>'userEmail',
                'disabled' => true,
            ])
            ->add('dateReclamation')
            ->add('description',TextareaType::class)
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Pending' => 'pending',
                    'In Progress' => 'in progress',
                    'Resolved' => 'resolved'
                ]
            ])
             ->add('rep',TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
