<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnexionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('pwd')
            ->add('numeroTel')
            ->add('address')
            ->add('role')
            ->add('urlImage')
            ->add('date')
            ->add('isdelete')
            ->add('datederniereconnx')
            ->add('domaineDeCompetence')
            ->add('tarifHoraire')
            ->add('portfolio')
            ->add('siteweb')
            ->add('gender')
            ->add('description')
            ->add('formeJuridique')
            ->add('refSpecialite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
