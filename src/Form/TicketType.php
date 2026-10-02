<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Champs
        $builder
            ->add('auteur', EmailType::class, ['label' => 'E-mail du client'])
            ->add('description', TextareaType::class, ['label' => 'Description', 'attr' => ['rows' => 5]])
            ->add('categorie', EntityType::class, ['class' => 'App\\Entity\\Categorie', 'choice_label' => 'libelle', 'label' => 'Catégorie'])
            ->add('etat', EntityType::class, ['class' => 'App\\Entity\\Etat', 'choice_label' => 'libelle', 'label' => 'État'])
            ->add('responsable', EntityType::class, ['class' => 'App\\Entity\\Responsable', 'choice_label' => 'nom', 'placeholder' => 'Aucun responsable', 'required' => false, 'label' => 'Responsable'])
            ->add('dateCloture', DateType::class, ['widget' => 'single_text', 'required' => false, 'label' => 'Date de clôture'])
            ->add('enregistrer', SubmitType::class, ['label' => 'Enregistrer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Ticket::class]);
    }
}
