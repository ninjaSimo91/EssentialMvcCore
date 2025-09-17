<?php
declare(strict_types=1);

namespace EssentialMVC\Core;

use EssentialMVC\Core\Exception\ServiceNotFoundException;

class ServiceContainer
{
    /** @var array<string, array{factory: callable, shared: bool}> */
    private array $definitions = [];

    /** @var array<string, mixed> */
    private array $sharedInstances = [];

    public function setShared(string $name, callable $factory): void
    {
        $this->definitions[$name] = ['factory' => $factory, 'shared' => true];
    }

    public function setTransient(string $name, callable $factory): void
    {
        $this->definitions[$name] = ['factory' => $factory, 'shared' => false];
    }

    public function get(string $name): mixed
    {
        if (!isset($this->definitions[$name])) {
            throw new ServiceNotFoundException("Service {$name} not found");
        }

        $definition = $this->definitions[$name];

        if ($definition['shared']) {
            if (!isset($this->sharedInstances[$name])) {
                $this->sharedInstances[$name] = $definition['factory']($this);
            }
            return $this->sharedInstances[$name];
        }

        return $definition['factory']($this);
    }
}
