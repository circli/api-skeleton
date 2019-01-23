<?php declare(strict_types=1);

use function DI\create;
use function DI\get;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\GroupCountBased as DataGeneratorGroupCountBased;
use Polus\Router\FastRoute\Dispatcher as FastRouteDispatcher;
use FastRoute\Dispatcher\GroupCountBased;
use Polus\MiddlewareDispatcher\DispatcherInterface as MiddlewareDispatcherInterface;
use Polus\MiddlewareDispatcher\Relay\Dispatcher as RelayDispatcher;
use Polus\Router\FastRoute\RouterCollection;
use Polus\Router\RouterCollectionInterface;
use Polus\Router\RouterDispatcherInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Diactoros\RequestFactory;
use Zend\Diactoros\ResponseFactory;

return [
    'adr.relay_resolver' => function (ContainerInterface $container) {
        return function ($middleware) use ($container) {
            if ($middleware instanceof MiddlewareInterface) {
                return $middleware;
            }

            return $container->get($middleware);
        };
    },
    ResponseFactoryInterface::class => DI\autowire(ResponseFactory::class),
    RequestFactoryInterface::class => create(RequestFactory::class),
    MiddlewareDispatcherInterface::class => create(RelayDispatcher::class)->constructor(
        get(ResponseFactoryInterface::class),
        get('adr.relay_resolver')
    ),
    RouteCollector::class => create(RouteCollector::class)->constructor(
        get(Std::class),
        get(DataGeneratorGroupCountBased::class)
    ),
    RouterCollectionInterface::class => DI\autowire(RouterCollection::class),
    RouterDispatcherInterface::class => function (ContainerInterface $container) {
        return new FastRouteDispatcher(
            GroupCountBased::class,
            $container->get(RouteCollector::class)
        );
    },
    'middlewares' => \DI\decorate(function ($previous) {
        //$previous[] = \App\Middleware\ClientIp::class;
        $previous[] = \Middlewares\Whoops::class;

        return $previous;
    }),
];