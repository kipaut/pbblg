<?php

namespace App\Command\Game;

use App\Domain\UserInGame\UserInGame;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use App\Command\Exception\NotAuthorizedException;
use App\Command\Exception\NotExistGameException;
use App\Domain\Game\Game;

class JoinGameCommand
{
    /**
     * @var RepositoryInterface
     */
    private $gameRepository;

    /**
     * @var RepositoryInterface
     */
    private $userInGameRepository;

    /**
     * @var RepositoryInterface
     */
    private $userRepository;

    /**
     * NewGameCommand constructor.
     * @param RepositoryInterface $gameRepository
     * @param RepositoryInterface $userInGameRepository
     * @param RepositoryInterface $userRepository
     */
    public function __construct(
        RepositoryInterface $gameRepository,
        RepositoryInterface $userInGameRepository,
        RepositoryInterface $userRepository
    ) {
        $this->gameRepository = $gameRepository;
        $this->userInGameRepository = $userInGameRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param JoinGameCommandContext $context
     * @return array
     */
    public function handle(JoinGameCommandContext $context)
    {
        if (!$context->getUser()) {
            throw new NotAuthorizedException();
        }

        /** @var Game $game */
        $game = $this->gameRepository->find([
            'gameId_equalTo' => $context->getGameId()
        ]);

        if ($game && $game->getStatus() != Game::STATUS_OPEN) {
            throw new NotExistGameException();
        }

        $userInGames = $this->userInGameRepository->findMany([
            'gameId_equalTo' => $context->getUser()->getId(),
        ]);

        /** @var UserInGame $userInGame */
        foreach ($userInGames as $userInGame) {
            //todo:: remove user from all other game
//            $this->webSocketClient->send([], new UserLeftGames(
//                $userInGame->getGameId(),
//                $context->getUser()->getId()
//            ));

//            $this->userInGameRepository->remove($userInGame);
        }

        $userInGame = new UserInGame([
            'userId' => $context->getUser()->getId(),
            'gameId' => $context->getGameId(),
        ]);

        $this->userInGameRepository->add($userInGame);




        //todo:: get users info
        $users = [];

        $usersInGame = $this->userInGameRepository->findMany([
            'gameId_equalTo' => $game->getId(),
            'userId_notEqualTo' => $context->getUser()->getId(),
        ]);

        return [
            'gameId' => $game->getId(),
            'users' => $users,
        ];
    }
}