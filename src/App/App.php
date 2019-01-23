<?php declare(strict_types=1);

namespace App;

use Circli\Core\Environment;
use Web\Guest\Actions\PingAction;

class App extends \Circli\WebCore\App
{
    public function __construct(Environment $mode)
    {
        parent::__construct($mode, Container::class);
    }

    protected function initAdr(): void
    {
        parent::initAdr();

        $this->adr->get('/ping', new PingAction());
    }
}
