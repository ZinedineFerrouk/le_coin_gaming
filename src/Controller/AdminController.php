<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Jeu;
use App\Form\AnnonceType;
use App\Form\JeuType;
use App\Form\JeuType2;
use App\Repository\AnnonceRepository;
use App\Repository\JeuRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use \Gumlet\ImageResize;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(AnnonceRepository $annonce, JeuRepository $jeux, UserRepository $user): Response
    {
        return $this->render('admin/index.html.twig', [
            'annonces' => $annonce->count([]),
            'jeux' => $jeux->count([]),
            'users' => $user->count([]),
        ]);
    }

    /* 
    ------------ ANNONCE -------------
    */
    /**
     * @Route("/annonces", name="admin_annonces", methods={"GET"})
     */
    public function les_annonce(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findAllAnnonce();
        $annoncesNonPub = $annonceRepository->annonceNonPublie();


        return $this->render('admin/annonces.html.twig', [
            'annonces' => $annonces,
            'NonPublier' => $annoncesNonPub,
        ]);
    }

    /**
     * @Route("/annonces/{id}", name="admin_annonce_show", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function show_annonce(Annonce $annonce): Response
    {
        $plateforme = $annonce->getPlateforme();
        $jeu = $annonce->getJeu();
        $user = $annonce->getUser();

        return $this->render('admin/annonce_show.html.twig', [
            'annonce' => $annonce,
            'jeu' => $jeu,
            'plateforme' => $plateforme,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/annonces/{id}/edit", name="admin_annonce_edit", methods={"GET","POST"}, requirements={"id": "\d+"})
     */
    public function edit_annonce(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_annonces');
        }

        return $this->render('admin/annonce_edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }


    /* 
    ------------------ JEUX -----------------
    */
    /**
     * @Route("/jeux", name="admin_jeu", methods={"GET"})
     */
    public function les_jeu(JeuRepository $jeuRepository): Response
    {
        $nonPublier = $jeuRepository->jeuxNonPublier();
        return $this->render('admin/jeux.html.twig', [
            'jeus' => $jeuRepository->findAll(),
            'NonPublier' => $nonPublier,
        ]);
    }


    /**
     * @Route("/jeux/{id}", name="admin_jeu_show", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function show_jeu(Jeu $jeu): Response
    {
        $annonces = $jeu->getAnnonces();

        return $this->render('admin/jeux_show.html.twig', [
            'jeu' => $jeu,
            'annonces' => $annonces,
        ]);
    }

    /**
     * @Route("/jeux/new_jeu", name="admin_jeu_new", methods={"GET","POST"})
     */
    public function new_jeu(Request $request, SluggerInterface $slugger): Response
    {
        $jeu = new Jeu();
        $form = $this->createForm(JeuType2::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            $imagePath = $this->getParameter('jeux_directory');

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                $filePath = $imagePath . '/' . $newFilename;

                try {
                    $image->move(
                        $imagePath,
                        $newFilename
                    );

                    $image = new ImageResize($filePath);
                    $image->resizeToWidth(480);
                    $image->save($filePath, IMAGETYPE_JPEG);

                } catch (FileException $e) {
                }

                $jeu->setImage('assets/images/games/' . $newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $jeu->setStatus('Publié');
            $entityManager->persist($jeu);
            $entityManager->flush();



            return $this->redirectToRoute('admin_jeu');
        }

        return $this->render('admin/jeux_new.html.twig', [
            'jeu' => $jeu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/jeux/{id}/edit", name="admin_jeu_edit", methods={"GET","POST"}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, Jeu $jeu): Response
    {
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_jeu');
        }

        return $this->render('admin/jeux_edit.html.twig', [
            'jeu' => $jeu,
            'form' => $form->createView(),
        ]);
    }
}
