<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Accueil
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrement
            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'ticket valide');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'ticketForm' => $form,
        ]);
    }

    // Pages
    #[Route('/tickets', name: 'app_tickets')]
    public function tickets(EntityManagerInterface $entityManager): Response
    {
        // Vérif connexion
        if (!$this->getUser()) {
            return $this->render('acces/index.html.twig');
        }

        // Organisation tickets
        $tickets = $entityManager->getRepository(Ticket::class)->findBy([], [
            'dateCreation' => 'DESC',
        ]);

        return $this->render('tickets/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/compte', name: 'app_compte')]
    public function compte(): Response
    {
        if (!$this->getUser()) {
            return $this->render('acces/index.html.twig');
        }

        // Infos compte
        return $this->render('compte/index.html.twig');
    }
}
