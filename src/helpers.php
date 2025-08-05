<?php

use EssentialMVC\App;
use EssentialMVC\Env;

function env(string $key, ?string $default = null): ?string
{
  return Env::get($key, $default);
}

function preprint(mixed $value, bool $varDump = false): void
{
  echo "<pre>";
  (!$varDump) ? print_r($value) : var_dump(($value));
  echo "</pre>";
}

function dd(mixed $value, bool $varDump = false): void
{
  echo "<pre>";
  (!$varDump) ? print_r($value) : var_dump(($value));
  echo "</pre>";
  die;
}

function route(string $name): string
{
  $app = App::getInstance();
  foreach ($app->config['routes'] as $methods) {
    foreach ($methods as $path => $attributes) {
      if (!empty($attributes['alias']) && $attributes['alias'] == $name) {
        return $app->basePath . $path;
      }
    }
  };
  return "";
}

function view(string $path, array $data = []): string
{
  $app = App::getInstance();
  // foreach ($app->config['routes'] as $methods) {
  //   foreach ($methods as $path => $attributes) {
  //     if (!empty($attributes['alias']) && $attributes['alias'] == $name) {
  //       return $app->basePath . $path;
  //     }
  //   }
  // };
  return "";
}
