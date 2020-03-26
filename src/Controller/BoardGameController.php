<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/board-game")
 */
class BoardGameController extends AbstractController
{
    /**
     * @Route("", methods="GET")
     */
    public function index(BoardGameRepository $repository)
    {
        // $boardGames = $repository->findBy(['ageGroup' => 10]);
        $boardGames = $repository->findWithCategories();

        return $this->render('board_game/index.html.twig', [
            'board_games' => $boardGames,
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     *
     * Composant ParamConverter est capable de traduire un paramètre de route en:
     * - Entité
     * - \DateTime
     */
    public function show(BoardGame $boardGame, ValidatorInterface $validator)
    {
        // pas utile ici, juste pour un exemple de validation hors formulaire
        $errors = $validator->validate($boardGame);
        return $this->render('board_game/show.html.twig', [
            'board_game' => $boardGame,
        ]);
    }
}
