<?php

namespace Src\Traits;

trait Getsalt
{
  protected function getSlt(): string
  {
    return file_get_contents(__DIR__ . '/../config/slt.txt');
  }
}
