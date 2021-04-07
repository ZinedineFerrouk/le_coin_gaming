<?php

namespace App\Controller;

use App\Entity\Plateforme;
use App\Form\PlateformeType;
use App\Repository\PlateformeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/plateforme")
 */
class PlateformeController extends AbstractController
{
    /**
     * @Route("/", name="plateforme_index", methods={"GET"})
     */
    public function index(PlateformeRepository $plateformeRepository): Response
    {
        return $this->render('plateforme/index.html.twig', [
            'plateformes' => $plateformeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="plateforme_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $plateforme = new Plateforme();
        $form = $this->createForm(PlateformeType::class, $plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plateforme);
            $entityManager->flush();

            return $this->redirectToRoute('plateforme_index');
        }

        return $this->render('plateforme/new.html.twig', [
            'plateforme' => $plateforme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plateforme_show", methods={"GET"})
     */
    public function show(Plateforme $plateforme): Response
    {
        return $this->render('plateforme/show.html.twig', [
            'plateforme' => $plateforme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="plateforme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Plateforme $plateforme): Response
    {
        $form = $this->createForm(PlateformeType::class, $plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plateforme_index');
        }

        return $this->render('plateforme/edit.html.twig', [
            'plateforme' => $plateforme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plateforme_delete", methods={"POST"})
     */
    public function delete(Request $request, Plateforme $plateforme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plateforme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plateforme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plateforme_index');
    }
}
