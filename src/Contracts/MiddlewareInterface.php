<?php

namespace EssentialMVC\Contracts;

use EssentialMVC\Core\App;

interface MiddlewareInterface
{

    public function exec(App $app);
}
