<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{    
    /**
    * @Route("/", name="profil")
    */
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }


    /**
     * @Route("/mesAnnonces", name="profil_annonce", methods={"GET"})
     */
    public function show(): Response
    {
        $user = $this->getUser();
        $annonces = $user->getAnnonces();
        return $this->render('profil/mesAnnonces.html.twig', [
            "annonces" => $annonces,
        ]);
    }
}
