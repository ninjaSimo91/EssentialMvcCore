<?php

namespace EssentialMVC\Contracts;

use EssentialMVC\App;

interface MiddlewareInterface
{

    public function exec(App $app);
}
