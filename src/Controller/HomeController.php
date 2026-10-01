<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Accueil
        return $this->render('home/index.html.twig');
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
