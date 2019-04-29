<?php

namespace App\Controller;

use App\Entity\DayOfWeek;
use App\Form\DayOfWeekType;
use App\Repository\DayOfWeekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/days")
 */
class DayOfWeekController extends AbstractController
{
    /**
     * @Route("/", name="day_of_week_index", methods={"GET"})
     */
    public function index(DayOfWeekRepository $dayOfWeekRepository): Response
    {
        return $this->render('day_of_week/index.html.twig', [
            'day_of_weeks' => $dayOfWeekRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="day_of_week_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dayOfWeek = new DayOfWeek();
        $form = $this->createForm(DayOfWeekType::class, $dayOfWeek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dayOfWeek);
            $entityManager->flush();

            return $this->redirectToRoute('day_of_week_index');
        }

        return $this->render('day_of_week/new.html.twig', [
            'day_of_week' => $dayOfWeek,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="day_of_week_show", methods={"GET"})
     */
    public function show(DayOfWeek $dayOfWeek): Response
    {
        return $this->render('day_of_week/show.html.twig', [
            'day_of_week' => $dayOfWeek,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="day_of_week_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DayOfWeek $dayOfWeek): Response
    {
        $form = $this->createForm(DayOfWeekType::class, $dayOfWeek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('day_of_week_index', [
                'id' => $dayOfWeek->getId(),
            ]);
        }

        return $this->render('day_of_week/edit.html.twig', [
            'day_of_week' => $dayOfWeek,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="day_of_week_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DayOfWeek $dayOfWeek): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dayOfWeek->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dayOfWeek);
            $entityManager->flush();
        }

        return $this->redirectToRoute('day_of_week_index');
    }
}
