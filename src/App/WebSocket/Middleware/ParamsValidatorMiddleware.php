<?php

namespace App\WebSocket\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use App\WebSocket\Exception\InternalErrorException;
use App\WebSocket\Exception\InvalidParamsException;
use App\WebSocket\Action\ParamsValidatorInterface;
use App\WebSocket\Router\Route;

use const Webimpress\HttpMiddlewareCompatibility\HANDLER_METHOD;

class ParamsValidatorMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface|null
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function __construct(
        ContainerInterface $container = null
    ) {
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /** @var Route $routeResult */
        $routeResult = $request->getAttribute(Route::class, false);

        /** @var ParamsValidatorInterface $paramsValidator */
        $paramsValidator = $this->container->get($routeResult->getParamsValidator());

        if (!$paramsValidator instanceof ParamsValidatorInterface) {
            throw new InternalErrorException('Bad params validator');
        }

        $paramsValidator->initialize($routeResult->getParamsConfig());

        if (!$paramsValidator->isValid($request->getAttribute('params'))) {
            throw new InvalidParamsException($paramsValidator->getErrors());
        }

        // Matched! Parse and pass on to the next
        return $delegate->{HANDLER_METHOD}(
            $request->withQueryParams($paramsValidator->getValid())
        );
    }
}
