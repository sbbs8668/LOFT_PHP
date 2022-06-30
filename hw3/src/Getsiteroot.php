<?php

namespace Src;

trait Getsiteroot
{
  public function gettroot(): string
  {
    return trim(file_get_contents(__DIR__ . '/pathtoroot.txt'));
  }
}
