<?php

namespace App\Command\Game;

use Psr\Container\ContainerInterface;

class JoinGameCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new JoinGameCommand(
            $container->get('Game\Infrastructure\Repository'),
            $container->get('UserInGame\Infrastructure\Repository'),
            $container->get('User\Infrastructure\Repository')
        );
    }
}
