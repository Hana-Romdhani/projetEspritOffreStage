<?php

namespace App\Form;

use App\Entity\Specialite;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // <-- Add this line
use Symfony\Component\Form\Extension\Core\Type\EmailType ;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UtilisateurType extends AbstractType
{       

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {        
        $request = Request::createFromGlobals();
        $defaultValue = $request->query->get('role');
        $builder
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class,[ 'required' => ($defaultValue === 'freelancer')])
            ->add('email',EmailType::class,['required'=>true])
            ->add('password',PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password']
                // 'constraints' => [
                //     new NotBlank([
                //         'message' => 'Please enter a password',
                //     ]),
                //     new Length([
                //         'min' => 6,
                //         'minMessage' => 'Your password should be at least {{ limit }} characters',
                //         // max length allowed by Symfony for security reasons
                //         'max' => 4096,
                //     ]),
                // ],
            ])
            ->add('urlImage', FileType::class, [
                'label' => 'Votre image de profil  (Image file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                       
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
            ->add('numeroTel')
            ->add('address')
            ->add('gender',ChoiceType::class, [
                'choices'  => [
                    'Femme' =>"Femme",
                    'Homme' => "Homme",
                 ],  'placeholder' => 'Choisissez votre genre','multiple'=>false,
                    'expanded'=>true ])

            ->add('roles',ChoiceType::class, [
                'choices'  => [
                    'Admin' =>"admin",
                    'etudiant' => "etudiant",
                    'Societe' => "societe"],'multiple'=>false,
                    'expanded'=>true, 'data' => $defaultValue  ])

        
            ->add('date',DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Date de creation  (JJ/MM/AAAA)*',
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTimeImmutable(),
                'disabled' => true, 
            ))
            ->add('isdelete',ChoiceType::class, [
                'choices'  => [
                    'Activer' => true,
                    ],'multiple'=>false,
                    'expanded'=>true ])
            ->add('domaineDeCompetence')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('portfolio',  FileType::class, [
                'label' => 'Brochure (PDF file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('siteweb')
            ->add('description')
            ->add('formeJuridique')
            ->add('refSpecialite',
            EntityType::class,[
                'class'=>Specialite::class,
                'choice_label'=>'domaine',
                'multiple'=>false,
                'expanded'=>false
            ])






            
            ->add('save', SubmitType::class, [
                'attr' =>  [
                    'class'=> 'btn btn-primary',
                ]
            ])
        ;

        // if ($defaultValue === 'societe') {
        //     $builder->add('refSpecialite', TextType::class, [
        //         'label' => 'Spécialité',
        //         'attr' => [
        //             'class' => 'form-control',
        //         ],
        //         'required' => true,
        //         'constraints' => [
        //             new NotBlank(),
        //         ],
        //     ]);
        // } else {
        //     $builder->add('refSpecialite', EntityType::class, [
        //         'label' => 'Spécialité',
        //         'class' => Specialite::class,
        //         'choice_label' => 'domaine',
        //         'multiple' => false,
        //         'expanded' => false,
        //         'attr' => [
        //             'class' => 'form-control',
        //         ],
        //         'required' => true,
        //     ]);
        // }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class
        ]);
    }
  


}
