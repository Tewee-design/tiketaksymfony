<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Etat;
use App\Entity\Responsable;
use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Catégories et états
        $categories = [];
        foreach (['Incident', 'Panne', 'Evolution', 'Anomalie', 'Information'] as $libelle) {
            $categorie = $manager->getRepository(Categorie::class)->findOneBy(['libelle' => $libelle]);
            if (!$categorie) {
                $categorie = (new Categorie())->setLibelle($libelle);
                $manager->persist($categorie);
            }
            $categories[$libelle] = $categorie;
        }

        $etats = [];
        foreach (['Nouveau', 'Ouvert', 'Résolu', 'Fermé'] as $libelle) {
            $etat = $manager->getRepository(Etat::class)->findOneBy(['libelle' => $libelle]);
            if (!$etat) {
                $etat = (new Etat())->setLibelle($libelle);
                $manager->persist($etat);
            }
            $etats[$libelle] = $etat;
        }

        $responsables = [];
        foreach ([['Camille Martin', 'camille.martin@agence.local'], ['Alex Durand', 'alex.durand@agence.local']] as [$nom, $email]) {
            $responsable = $manager->getRepository(Responsable::class)->findOneBy(['email' => $email]);
            if (!$responsable) {
                $responsable = (new Responsable())->setNom($nom)->setEmail($email);
                $manager->persist($responsable);
            }
            $responsables[] = $responsable;
        }

        // Comptes test
        foreach ([['skillandyou@tiketak.local', 'skillandyou123!', 'ROLE_ADMIN'], ['personnel@tickets.local', 'Personnel123!', 'ROLE_EMPLOYE']] as [$email, $password, $role]) {
            $user = $manager->getRepository(User::class)->findOneBy(['email' => $email]);
            if (!$user) {
                $user = (new User())->setEmail($email);
                $manager->persist($user);
            }
            $user->setRoles([$role]);
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        }

        $exemples = [
            ['client1@example.fr', 'L’accès à mon espace client affiche une page blanche depuis ce matin.', 'Incident', 'Nouveau', 0],
            ['client2@example.fr', 'Je ne peux plus enregistrer mes modifications dans le formulaire de contact.', 'Panne', 'Ouvert', 1],
            ['client3@example.fr', 'La recherche affiche parfois des résultats qui ne correspondent pas au mot saisi.', 'Anomalie', 'Résolu', 0],
        ];
        foreach ($exemples as [$auteur, $description, $categorie, $etat, $responsable]) {
            if (!$manager->getRepository(Ticket::class)->findOneBy(['auteur' => $auteur, 'description' => $description])) {
                $ticket = (new Ticket())->setAuteur($auteur)->setDescription($description)->setCategorie($categories[$categorie])->setEtat($etats[$etat])->setResponsable($responsables[$responsable]);
                $manager->persist($ticket);
            }
        }

        $manager->flush();
    }
}
