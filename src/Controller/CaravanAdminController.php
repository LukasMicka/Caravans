<?php

namespace App\Controller;

use App\Entity\Caravan;
use App\Form\CaravanType;
use App\Repository\CaravanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/caravan-admin")
 */
class CaravanAdminController extends AbstractController
{
    /**
     * @Route("/", name="caravan_index", methods={"GET"})
     */
    public function index(CaravanRepository $caravanRepository): Response
    {    
        return $this->render('caravan_admin/index.html.twig', [
            'caravans' => $caravanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="caravan_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $caravan = new Caravan();
        $form = $this->createForm(CaravanType::class, $caravan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($caravan);
            $entityManager->flush();

            return $this->redirectToRoute('caravan_index');
        }

        return $this->render('caravan_admin/new.html.twig', [
            'caravan' => $caravan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="caravan_show", methods={"GET"})
     */
    public function show(Caravan $caravan): Response
    {
        return $this->render('caravan_admin/show.html.twig', [
            'caravan' => $caravan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="caravan_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Caravan $caravan): Response
    {
        $form = $this->createForm(CaravanType::class, $caravan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('caravan_index');
        }

        return $this->render('caravan_admin/edit.html.twig', [
            'caravan' => $caravan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="caravan_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Caravan $caravan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$caravan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($caravan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('caravan_index');
    }
}
