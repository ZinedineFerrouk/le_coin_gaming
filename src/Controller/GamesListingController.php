<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Repository\JeuRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamesListingController extends AbstractController
{
    /**
     * @Route("/jeux/listing", name="games_listing")
     */
    public function index(JeuRepository $jeuRepository): Response
    {
        // dd($jeuRepository->findAllWithPlateformeAndAnnonce());

        // Récupèrer tous les jeux vidéos (image, titre, date_dortie->prendre que l'année) -> status 'publie'
        return $this->render('games_listing/index.html.twig', [
            'jeux' => $jeuRepository->findAllWithPlateformeAndAnnonce()
        ]);
    }
}
