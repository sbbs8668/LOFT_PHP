<?php

namespace Src\Traits;

trait Makepswd
{
  protected function makePswd(): string
  {
    return sha1($this->getSlt() . $_POST['pswd']);
  }
}
