<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketEtatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tickets')]
class TicketController extends AbstractController
{
    #[Route('', name: 'app_ticket_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Vérif connexion
        if (!$this->getUser()) {
            return $this->render('acces/index.html.twig');
        }
        $this->denyAccessUnlessGranted('ROLE_EMPLOYE');
        $tickets = $entityManager->getRepository(Ticket::class)->findBy([], ['dateOuverture' => 'DESC']);
        return $this->render('ticket/index.html.twig', ['tickets' => $tickets]);
    }

    #[Route('/{id}', name: 'app_ticket_show', requirements: ['id' => '\\d+'])]
    public function show(Ticket $ticket): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EMPLOYE');
        return $this->render('ticket/show.html.twig', ['ticket' => $ticket]);
    }

    #[Route('/{id}/etat', name: 'app_ticket_etat', requirements: ['id' => '\\d+'])]
    public function etat(Ticket $ticket, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EMPLOYE');
        $form = $this->createForm(TicketEtatType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Modif état
            $entityManager->flush();
            $this->addFlash('success', 'L’état du ticket a été mis à jour.');
            return $this->redirectToRoute('app_ticket_show', ['id' => $ticket->getId()]);
        }
        return $this->render('ticket/etat.html.twig', ['ticket' => $ticket, 'form' => $form]);
    }
}
