<?php

namespace App\Controller\Admin;

use App\Entity\BoardGame;
use App\Form\BoardGameType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/board-game")
 * @IsGranted("ROLE_ADMIN")
 */
class BoardGameController extends AbstractController
{
    /**
     * @Route("/new", methods={"GET", "POST"})
     * @IsGranted("ROLE_AUTHOR")
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $game = new BoardGame();
        $game->setAuthoredBy($this->getUser());

        $form = $this->createForm(BoardGameType::class, $game);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($game);
            $manager->flush();

            $this->addFlash('success', 'Nouveau jeu créé');
            return $this->redirectToRoute('app_boardgame_show', [
                'id' => $game->getId(),
            ]);
        }

        return $this->render('board_game/new.html.twig', [
            'new_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET", "PUT"})
     * @IsGranted("GAME_EDIT", subject="game")
     */
    public function edit(
        BoardGame $game,
        Request $request,
        EntityManagerInterface $manager
    ) {
        $form = $this->createForm(BoardGameType::class, $game, [
            'method' => 'PUT',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', $game->getName().' mis à jour');
            return $this->redirectToRoute('app_boardgame_show', [
                'id' => $game->getId(),
            ]);
        }

        return $this->render('board_game/edit.html.twig', [
            'game' => $game,
            'edit_form' => $form->createView(),
        ]);
    }
}