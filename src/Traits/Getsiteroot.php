<?php

namespace Src\Traits;

trait Getsiteroot
{
  public function getRoot(): string
  {
      $rootPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', getcwd());
      return $rootPath . DIRECTORY_SEPARATOR;
  }
}
