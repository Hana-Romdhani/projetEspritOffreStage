<?php

namespace App\Form;

use App\Entity\QuestionAnswer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', TextareaType::class, [
                'label' => 'Question',
                'attr' => [
                    'placeholder' => 'Enter a question',
                ],
            ])
            ->add('answer', TextareaType::class, [
                'label' => 'Answer',
                'attr' => [
                    'placeholder' => 'Enter the answer',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuestionAnswer::class,
        ]);
    }
}
