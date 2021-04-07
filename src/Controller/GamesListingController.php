<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamesListingController extends AbstractController
{
    /**
     * @Route("/games/listing", name="games_listing")
     */
    public function index(): Response
    {
        // Récupèrer tous les jeux vidéos (image, titre, date_dortie->prendre que l'année)
        return $this->render('games_listing/index.html.twig', [
            
        ]);
    }
}
