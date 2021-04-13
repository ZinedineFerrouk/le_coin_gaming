<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType2;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function profilAnnonce(): Response
    {
        $user = $this->getUser();
        $annonces = $user->getAnnonces();
        return $this->render('profil/mesAnnonces.html.twig', [
            "annonces" => $annonces,
        ]);
    }
    

    /**
     * @Route("/myprofil", name="profil_user", methods={"GET","POST"})
     */
    public function profilUser(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType2::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('profil/monProfil.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/myprofil", name="profil_user", methods={"GET"})
     */
   /*  public function profilUser(): Response
    {
        $user = $this->getUser();
        return $this->render('profil/monProfil.html.twig', [
            "user" => $user,
        ]);
    } */
}
