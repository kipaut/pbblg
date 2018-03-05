<?php

namespace App\Command\Game;

use App\Domain\User\User;

class JoinGameCommandContext
{
    /**
     * @var User|null
     */
    private $user;

    /**
     * @var int|null
     */
    private $gameId;

    /**
     * NewGameCommandContext constructor.
     * @param User $user
     * @param int $gameId
     */
    public function __construct(User $user = null, int $gameId = null)
    {
        $this->user = $user;
        $this->gameId = $gameId;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return User|null
     */
    public function getGameId(): ?int
    {
        return $this->gameId;
    }
}