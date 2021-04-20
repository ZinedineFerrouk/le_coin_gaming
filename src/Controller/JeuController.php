<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Form\JeuType;
use App\Form\JeuType2;
use App\Repository\JeuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use \Gumlet\ImageResize;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @Route("/jeu")
 */
class JeuController extends AbstractController
{
    /**
     * @Route("/", name="jeu_index", methods={"GET"})
     */
    public function index(JeuRepository $jeuRepository): Response
    {
        return $this->render('jeu/index.html.twig', [
            'jeus' => $jeuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="jeu_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
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
            $jeu->setStatus('Non-Publié');
            $entityManager->persist($jeu);
            $entityManager->flush();

            $this->addFlash('success', 'Le jeux doit être validé par un administrateur avant publication');
            return $this->redirectToRoute('annonce_new');
        }

        return $this->render('jeu/new.html.twig', [
            'jeu' => $jeu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jeu_show", methods={"GET"})
     */
    public function show(Jeu $jeu): Response
    {
        $annonces = $jeu->getAnnonces();

        return $this->render('jeu/show.html.twig', [
            'jeu' => $jeu,
            'annonces' => $annonces,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="jeu_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Jeu $jeu): Response
    {
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jeu_index');
        }

        return $this->render('jeu/edit.html.twig', [
            'jeu' => $jeu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jeu_delete", methods={"POST"})
     */
    public function delete(Request $request, Jeu $jeu): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jeu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jeu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_jeu');
    }
}
