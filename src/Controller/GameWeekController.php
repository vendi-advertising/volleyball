<?php

namespace App\Controller;

use App\Entity\GameWeek;
use App\Form\GameWeekType;
use App\Repository\GameWeekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gameweek")
 */
class GameWeekController extends AbstractController
{
    /**
     * @Route("/", name="game_week_index", methods={"GET"})
     */
    public function index(GameWeekRepository $gameWeekRepository): Response
    {
        return $this->render('game_week/index.html.twig', [
            'game_weeks' => $gameWeekRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="game_week_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gameWeek = new GameWeek();
        $form = $this->createForm(GameWeekType::class, $gameWeek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gameWeek);
            $entityManager->flush();

            return $this->redirectToRoute('game_week_index');
        }

        return $this->render('game_week/new.html.twig', [
            'game_week' => $gameWeek,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_week_show", methods={"GET"})
     */
    public function show(GameWeek $gameWeek): Response
    {
        return $this->render('game_week/show.html.twig', [
            'game_week' => $gameWeek,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="game_week_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GameWeek $gameWeek): Response
    {
        $form = $this->createForm(GameWeekType::class, $gameWeek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_week_index', [
                'id' => $gameWeek->getId(),
            ]);
        }

        return $this->render('game_week/edit.html.twig', [
            'game_week' => $gameWeek,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_week_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GameWeek $gameWeek): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gameWeek->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gameWeek);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_week_index');
    }
}
