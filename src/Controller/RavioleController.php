<?php

namespace App\Controller;

use App\Entity\Raviole;
use App\Form\RavioleType;
use App\Repository\RavioleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/raviole")
 */
class RavioleController extends AbstractController
{
    /**
     * @Route("/", name="raviole_index", methods={"GET"})
     */
    public function index(RavioleRepository $ravioleRepository): Response
    {
        return $this->render('raviole/index.html.twig', [
            'ravioles' => $ravioleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="raviole_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $raviole = new Raviole();
        $form = $this->createForm(RavioleType::class, $raviole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($raviole);
            $entityManager->flush();

            return $this->redirectToRoute('raviole_index');
        }

        return $this->render('raviole/new.html.twig', [
            'raviole' => $raviole,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="raviole_show", methods={"GET"})
     */
    public function show(Raviole $raviole): Response
    {
        return $this->render('raviole/show.html.twig', [
            'raviole' => $raviole,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="raviole_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Raviole $raviole): Response
    {
        $form = $this->createForm(RavioleType::class, $raviole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('raviole_index');
        }

        return $this->render('raviole/edit.html.twig', [
            'raviole' => $raviole,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="raviole_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Raviole $raviole): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raviole->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($raviole);
            $entityManager->flush();
        }

        return $this->redirectToRoute('raviole_index');
    }
}
