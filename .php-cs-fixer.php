<?php
declare(strict_types=1);

return PhpCsFixer\Config::create()
  ->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'declare_strict_types' => true,
  ])
  ->setFinder(
    PhpCsFixer\Finder::create()->in(__DIR__ . '/src')
  );
