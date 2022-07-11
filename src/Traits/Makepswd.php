<?php

namespace Src\Traits;

trait Makepswd
{
  protected function makePswd(string $pswd = ''): string
  {
    $pswd = $pswd ?: $_POST['pswd'];
    return sha1($this->getSlt() . $pswd);
  }
}
