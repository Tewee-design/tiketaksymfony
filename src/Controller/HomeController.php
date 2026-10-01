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
    public function tickets(): Response
    {
        return $this->render('tickets/index.html.twig');
    }

    #[Route('/compte', name: 'app_compte')]
    public function compte(): Response
    {
        return $this->render('compte/index.html.twig');
    }

    #[Route('/deconnexion', name: 'app_deconnexion')]
    public function deconnexion(): Response
    {
        return $this->render('deconnexion/index.html.twig');
    }
}
