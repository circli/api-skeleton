<?php

namespace App;

use Circli\WebCore\PathContainer;

class Container extends \Circli\WebCore\Container
{
    protected function getPathContainer(): \Circli\Contracts\PathContainer
    {
        return new PathContainer(dirname(__DIR__, 2));
    }
}
