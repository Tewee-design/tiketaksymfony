<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompteController extends AbstractController
{
    #[Route('/compte', name: 'app_compte')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->render('acces/index.html.twig');
        }

        // Infos compte
        return $this->render('compte/index.html.twig');
    }
}
