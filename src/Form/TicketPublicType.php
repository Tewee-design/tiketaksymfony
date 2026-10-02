<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketPublicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Champs
        $builder
            ->add('auteur', EmailType::class, ['label' => 'Adresse e-mail'])
            ->add('description', TextareaType::class, ['label' => 'Description du problème', 'attr' => ['rows' => 5, 'placeholder' => 'Décrivez votre demande en 20 à 250 caractères.']])
            ->add('categorie', EntityType::class, ['class' => 'App\\Entity\\Categorie', 'choice_label' => 'libelle', 'placeholder' => 'Choisir une catégorie', 'label' => 'Catégorie'])
            ->add('envoyer', SubmitType::class, ['label' => 'Envoyer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Ticket::class]);
    }
}
