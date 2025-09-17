<?php
declare(strict_types=1);

namespace EssentialMVC\Core\Exception;

class NotFoundException extends \Exception
{

    public function __construct(
        string $message = 'Pagina non trovata!',
        int $code = 404
    ) {
        parent::__construct($message, $code);
    }
}
