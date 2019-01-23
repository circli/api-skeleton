<?php declare(strict_types=1);

namespace Web\Guest\Payload;

use Aura\Payload_Interface\PayloadStatus;
use Circli\WebCore\Common\Payload\AbstractPayload;

class PingPayload extends AbstractPayload
{
	public const SUCCESS = PayloadStatus::SUCCESS;

	protected const ALLOWED_STATUS = [self::SUCCESS];

	public function __construct(string $status)
	{
		parent::__construct($status, 'pong');
		$this->output->ping = 'pong';
	}
}
