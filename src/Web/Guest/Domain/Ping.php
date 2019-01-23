<?php declare(strict_types=1);

namespace Web\Guest\Domain;

use Web\Guest\Payload\PingPayload;

class Ping
{
	public function __invoke()
	{
		return new PingPayload(PingPayload::SUCCESS);
	}
}
