<?php

namespace EssentialMVC\Core\Contracts;

use EssentialMVC\Core\App;

interface MiddlewareInterface
{

    public function exec(App $app);
}
