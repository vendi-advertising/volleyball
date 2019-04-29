<?php

namespace App\Controller;

use App\Entity\GameNight;
use App\Form\GameNight1Type;
use App\Repository\GameNightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gamenight")
 */
class GameNightController extends AbstractController
{
    /**
     * @Route("/", name="game_night_index", methods={"GET"})
     */
    public function index(GameNightRepository $gameNightRepository): Response
    {
        return $this->render('game_night/index.html.twig', [
            'game_nights' => $gameNightRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="game_night_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gameNight = new GameNight();
        $form = $this->createForm(GameNight1Type::class, $gameNight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gameNight);
            $entityManager->flush();

            return $this->redirectToRoute('game_night_index');
        }

        return $this->render('game_night/new.html.twig', [
            'game_night' => $gameNight,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_night_show", methods={"GET"})
     */
    public function show(GameNight $gameNight): Response
    {
        return $this->render('game_night/show.html.twig', [
            'game_night' => $gameNight,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="game_night_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GameNight $gameNight): Response
    {
        $form = $this->createForm(GameNight1Type::class, $gameNight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_night_index', [
                'id' => $gameNight->getId(),
            ]);
        }

        return $this->render('game_night/edit.html.twig', [
            'game_night' => $gameNight,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_night_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GameNight $gameNight): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gameNight->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gameNight);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_night_index');
    }
}
