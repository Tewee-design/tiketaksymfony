<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketPublicType;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager, EtatRepository $etats): Response
    {
        // Accueil
        $ticket = new Ticket();
        $form = $this->createForm(TicketPublicType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Départ
            $ticket->setEtat($etats->findOneBy(['libelle' => 'Nouveau']));
            // Enregistrement
            $entityManager->persist($ticket);
            $entityManager->flush();
            $this->addFlash('success', 'Ticket validé');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', ['form' => $form]);
    }
}
