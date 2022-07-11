<?php

namespace Src\Traits;

trait Clearerrors
{
  protected function clearErrors(): void
  {
    $_SESSION['errors'] = '';
  }
}
