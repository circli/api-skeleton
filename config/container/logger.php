<?php declare(strict_types=1);

use Circli\Core\Environment;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

return [
	LoggerInterface::class => function (ContainerInterface $container) {
		$logger = new Logger('tunnel-api');
		$logger->pushHandler(
			new StreamHandler(
				$container->get('app.basePath') . '/log/' . $container->get('app.mode') . '.log',
				$container->get('app.mode')->is(Environment::PRODUCTION()) ? Logger::ERROR : Logger::DEBUG
			)
		);
		$logger->pushProcessor(new UidProcessor());

		return $logger;
	},
];
