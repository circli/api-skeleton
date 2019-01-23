<?php declare(strict_types=1);

namespace Web\Guest\Actions;

use Circli\WebCore\Common\Actions\AbstractAction;
use Web\Guest\Domain\Ping;

class PingAction extends AbstractAction
{
	protected $domain = Ping::class;
}
