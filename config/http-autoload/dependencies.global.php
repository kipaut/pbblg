<?php

use Zend\Expressive\Container;
use Zend\Expressive\Delegate;
use Zend\Expressive\Helper;
use Zend\Expressive\Middleware;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            'Zend\Expressive\Delegate\DefaultDelegate' => Delegate\NotFoundDelegate::class,
            Zend\Expressive\Authentication\UserRepositoryInterface::class => Zend\Expressive\Authentication\UserRepository\PdoDatabase::class,
            Zend\Expressive\Session\SessionPersistenceInterface::class => App\Infrastructure\PhpSessionPersistence::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories'  => [
            Zend\Stratigility\Middleware\ErrorHandler::class => Container\ErrorHandlerFactory::class,
            Middleware\ErrorResponseGenerator::class         => Container\ErrorResponseGeneratorFactory::class,
            Middleware\NotFoundHandler::class                => Container\NotFoundHandlerFactory::class,

            Zend\Expressive\Authentication\AuthenticationInterface::class => Zend\Expressive\Authentication\Session\PhpSessionFactory::class,
        ],
    ],
];
