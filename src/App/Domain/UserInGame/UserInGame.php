<?php

namespace App\Domain\UserInGame;

use T4webDomain\Entity;

class UserInGame extends Entity
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var int
     */
    protected $gameId;

    /**
     * @var string
     */
    protected $joinedDt;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getGameId(): int
    {
        return $this->gameId;
    }
}