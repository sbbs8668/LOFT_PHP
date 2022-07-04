<?php
namespace App\Controller;

use Src\AbstractController;

class User extends AbstractController
{
  private function proceed(): void
  {
    $this->fileTemplateUrl = $this->getFileUrl(__DIR__, $this->class, $this->method);
    $this->modelClassPath = $this->getModeClassPath($this->class, $this->method);
  }
  public function login(): void{
    if (isset($_SESSION['user']) && $_SESSION['user']) {
      /* if a user is signed up -> redirect to blog */
      $this->toBlog();
      $this->proceed();
    } else {
      /*go to login page*/
      $this->method = __METHOD__;
      $this->class = __CLASS__;
      $this->proceed();
    }
  }
  public function register(): void
  {
    if (isset($_SESSION['user']) && $_SESSION['user']) {
      /* if a user is signed up -> redirect to blog */
      $this->toBlog();
      $this->proceed();
    } else {
      /*go to register page*/
      $this->method = __METHOD__;
      $this->class = __CLASS__;
      $this->proceed();
    }
  }
  public function changerole(): void
  {
    if (isset($_SESSION['user']) && $_SESSION['user']) {
      $this->method = __METHOD__;
      $this->class = __CLASS__;
      $this->proceed();
    }
  }
  public function signout(): void
  {
    $this->method = __METHOD__;
    $this->class = __CLASS__;
    $this->proceed();
  }
}
