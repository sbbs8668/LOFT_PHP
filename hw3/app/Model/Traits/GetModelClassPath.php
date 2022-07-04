<?php
namespace App\Model\Traits;

trait GetModelClassPath {
  protected function getModeClassPath(string $class, string $method): array
  {
    $class = explode('\\', $class);
    $class = $class[count($class) - 1];
    $method = ucfirst(explode('::', $method)[1]);
    return [$class, $method];
  }
}
