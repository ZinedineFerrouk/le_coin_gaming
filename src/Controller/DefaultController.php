<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\JeuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
    * @Route("/", name="home")
    */
    public function index(JeuRepository $repo, AnnonceRepository $annonceRepo): Response
    {
        $lastThreegames = $repo->getLastResults(3,0);
        $lastFourgames = $repo->getLastResults(4,3);
        $lastSixjeux = $annonceRepo->getLastResults(6,0);
        
        return $this->render('default/index.html.twig', [
            'lastThreeGames' => $lastThreegames,
            'lastFourgames' => $lastFourgames,
            'lastSixjeux' => $lastSixjeux,
            

        ]);
    }

    
}
