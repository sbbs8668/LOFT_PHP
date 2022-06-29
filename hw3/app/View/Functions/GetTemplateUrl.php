<?php
namespace App\View\Functions;

const VIEW_DIR = 'View';
const FILE_EXT = '.phtml';
const CD_BACK = '..';

trait GetTemplateUrl {
  protected function getFileUrl(string $dir, string $class, string $method): string
  {
    //$namespace = explode('\\', $namespace)[0];
    /*class name = folder name, eg. 'Register'*/
    $class = explode('\\', $class);
    $class = $class[count($class) - 1];
    /*method name = file name, eg. 'register'*/
    $method = strtolower(explode('::', $method)[1]);
    return
      $dir .
      DIRECTORY_SEPARATOR .
      CD_BACK .
      DIRECTORY_SEPARATOR .
      VIEW_DIR .
      DIRECTORY_SEPARATOR .
      $class .
      DIRECTORY_SEPARATOR .
      $method .
      FILE_EXT;
  }
}
