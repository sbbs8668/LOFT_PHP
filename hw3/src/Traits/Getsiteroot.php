<?php

namespace Src\Traits;

trait Getsiteroot
{
  public function getRoot(): string
  {
    return trim(file_get_contents(__DIR__ . '/../config/pathtoroot.txt'));
  }
}
