<?php

namespace App\WebSocket\Action\JoinGame;

use App\Command\Game\JoinGameCommandContext;
use Psr\Http\Message\ServerRequestInterface;
use App\WebSocket\Action\ActionHandlerInterface;
use App\WebSocket\Client;
use App\WebSocket\Event\UserJoinGame;
use App\Command\Game\JoinGameCommand;

class JoinGameHandler implements ActionHandlerInterface
{
    /**
     * @var JoinGameCommand
     */
    private $command;

    /**
     * @var Client
     */
    private $webSocketClient;

    public function __construct(
        JoinGameCommand $command,
        Client $webSocketClient
    ) {
        $this->command = $command;
        $this->webSocketClient = $webSocketClient;
    }

    /**
     * @param ServerRequestInterface $request
     * @return mixed result
     */
    public function handle(ServerRequestInterface $request)
    {
        $context = new JoinGameCommandContext(
            $request->getAttribute('currentUser'),
            $request->getQueryParams()['gameId']
        );

        $result = $this->command->handle($context);

        $this->webSocketClient->send([], new UserJoinGame(
            $result['gameId'],
            $request->getAttribute('currentUser')->getId()
        ));

        return $result;
    }
}
