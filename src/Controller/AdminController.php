<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Etat;
use App\Entity\Responsable;
use App\Entity\Ticket;
use App\Form\CategorieType;
use App\Form\EtatType;
use App\Form\ResponsableType;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('admin/index.html.twig', [
            'nbTickets' => $entityManager->getRepository(Ticket::class)->count([]),
            'nbCategories' => $entityManager->getRepository(Categorie::class)->count([]),
            'nbEtats' => $entityManager->getRepository(Etat::class)->count([]),
            'nbResponsables' => $entityManager->getRepository(Responsable::class)->count([]),
        ]);
    }

    #[Route('/categories', name: 'app_admin_categories')]
    public function categories(EntityManagerInterface $entityManager): Response
    {
        return $this->render('admin/list.html.twig', ['titre' => 'Catégories', 'items' => $entityManager->getRepository(Categorie::class)->findAll(), 'routeNew' => 'app_admin_categorie_new', 'routeEdit' => 'app_admin_categorie_edit', 'champ' => 'libelle']);
    }

    #[Route('/categories/nouveau', name: 'app_admin_categorie_new')]
    public function categorieNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->formulaire($request, $entityManager, new Categorie(), CategorieType::class, 'Nouvelle catégorie', 'app_admin_categories');
    }

    #[Route('/categories/{id}/modifier', name: 'app_admin_categorie_edit', requirements: ['id' => '\\d+'])]
    public function categorieEdit(Categorie $categorie, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->formulaire($request, $entityManager, $categorie, CategorieType::class, 'Modifier une catégorie', 'app_admin_categories');
    }

    #[Route('/etats', name: 'app_admin_etats')]
    public function etats(EntityManagerInterface $entityManager): Response
    {
        return $this->render('admin/list.html.twig', ['titre' => 'États', 'items' => $entityManager->getRepository(Etat::class)->findAll(), 'routeNew' => 'app_admin_etat_new', 'routeEdit' => 'app_admin_etat_edit', 'champ' => 'libelle']);
    }

    #[Route('/etats/nouveau', name: 'app_admin_etat_new')]
    public function etatNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->formulaire($request, $entityManager, new Etat(), EtatType::class, 'Nouvel état', 'app_admin_etats');
    }

    #[Route('/etats/{id}/modifier', name: 'app_admin_etat_edit', requirements: ['id' => '\\d+'])]
    public function etatEdit(Etat $etat, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->formulaire($request, $entityManager, $etat, EtatType::class, 'Modifier un état', 'app_admin_etats');
    }

    #[Route('/responsables', name: 'app_admin_responsables')]
    public function responsables(EntityManagerInterface $entityManager): Response
    {
        return $this->render('admin/list.html.twig', ['titre' => 'Responsables', 'items' => $entityManager->getRepository(Responsable::class)->findAll(), 'routeNew' => 'app_admin_responsable_new', 'routeEdit' => 'app_admin_responsable_edit', 'champ' => 'nom']);
    }

    #[Route('/responsables/nouveau', name: 'app_admin_responsable_new')]
    public function responsableNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->formulaire($request, $entityManager, new Responsable(), ResponsableType::class, 'Nouveau responsable', 'app_admin_responsables');
    }

    #[Route('/responsables/{id}/modifier', name: 'app_admin_responsable_edit', requirements: ['id' => '\\d+'])]
    public function responsableEdit(Responsable $responsable, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->formulaire($request, $entityManager, $responsable, ResponsableType::class, 'Modifier un responsable', 'app_admin_responsables');
    }

    #[Route('/tickets', name: 'app_admin_tickets')]
    public function tickets(EntityManagerInterface $entityManager): Response
    {
        return $this->render('admin/tickets.html.twig', ['tickets' => $entityManager->getRepository(Ticket::class)->findBy([], ['dateOuverture' => 'DESC'])]);
    }

    #[Route('/tickets/nouveau', name: 'app_admin_ticket_new')]
    public function ticketNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->formulaire($request, $entityManager, new Ticket(), TicketType::class, 'Nouveau ticket', 'app_admin_tickets');
    }

    #[Route('/tickets/{id}/modifier', name: 'app_admin_ticket_edit', requirements: ['id' => '\\d+'])]
    public function ticketEdit(Ticket $ticket, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->formulaire($request, $entityManager, $ticket, TicketType::class, 'Modifier le ticket', 'app_admin_tickets');
    }

    private function formulaire(Request $request, EntityManagerInterface $entityManager, object $objet, string $type, string $titre, string $routeRetour): Response
    {
        // Données
        $form = $this->createForm($type, $objet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($objet);
            $entityManager->flush();
            $this->addFlash('success', 'Les informations ont été enregistrées.');
            return $this->redirectToRoute($routeRetour);
        }
        return $this->render('admin/form.html.twig', ['titre' => $titre, 'form' => $form, 'routeRetour' => $routeRetour]);
    }
}
