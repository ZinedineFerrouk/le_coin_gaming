<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Jeu;
use App\Repository\JeuRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JasonGrimes\Paginator;

class GamesListingController extends AbstractController
{
    /**
     * @Route("/jeux/listing", name="games_listing", methods={"GET"})
     */
    public function index(JeuRepository $jeuRepository, Request $request): Response
    {
        // PAGINATION
        $itemsPerPage = 5;
        $totalItems = $jeuRepository->count([]);
        $currentPage = $request->query->get('page', 1);
        $urlPattern = '?page=(:num)';
        $offset = ($currentPage - 1) * $itemsPerPage;
        
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $jeux = $jeuRepository->findAllWithPlateformeAndAnnonce($itemsPerPage, $offset);
        // dd($jeux);

        return $this->render('games_listing/index.html.twig', [
            'jeux' => $jeux,
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/jeux/annonces/{id}", name="annonces_per_game", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function annoncePerGame(Jeu $jeu): Response
    {
        $annonces = $jeu->getAnnonces();

        // Récupèrer tous les jeux vidéos (image, titre, date_dortie->prendre que l'année) -> status 'publie'
        return $this->render('games_listing/annonces_per_game.html.twig', [
            'annonces' => $annonces,
            'jeu' => $jeu
        ]);
    }
}
