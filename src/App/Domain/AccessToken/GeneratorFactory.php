<?php

namespace App\Domain\AccessToken;

use Psr\Container\ContainerInterface;

class GeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Generator(
            $container->get('AccessToken\Infrastructure\Repository'),
            $container->get('User\Infrastructure\Repository')
        );
    }
}
