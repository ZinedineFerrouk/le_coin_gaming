<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Form\AnnonceType2;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annonce")
 */
class AnnonceController extends AbstractController
{
    /**
     * @Route("/", name="annonce_index", methods={"GET"})
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findAllAnnonce();
        //dd($annonceRepository->findAll());
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    /**
     * @Route("/new", name="annonce_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType2::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $annonce->setCreatedAt(new \DateTime());
            $annonce->setUser($this->getUser());
            $annonce->setStatus('Non-Publié');
            $entityManager->persist($annonce);
            $entityManager->flush();

            $this->addFlash('success', 'Votre annonce doit être validé par un administrateur avant publication');
            return $this->redirectToRoute('games_listing');
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/jeux/{id}", name="annonce_show", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function show(Annonce $annonce): Response
    {
        $plateforme = $annonce->getPlateforme();
        $jeu = $annonce->getJeu();
        $user = $annonce->getUser();

        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'jeu' => $jeu,
            'plateforme' => $plateforme,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="annonce_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Annonce $annonce): Response
    {
        $proprio = $annonce->getUser();
        $userActuel = $this->getUser();

        if ($proprio != $userActuel) {
            return $this->redirectToRoute('home');
        }
        $form = $this->createForm(AnnonceType2::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('profil_annonce');
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="annonce_delete", methods={"POST"})
     */
    public function delete(Request $request, Annonce $annonce): Response
    {
        $proprio = $annonce->getUser();
        $userActuel = $this->getUser();
        if ($proprio != $userActuel) {
            return $this->redirectToRoute('home');
        }
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profil_annonce');
    }
}
