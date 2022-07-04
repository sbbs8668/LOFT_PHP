<?php

namespace App\Controller;
use Src\PdoDb;
use Src\AbstractController;

class Blog extends AbstractController
{
  protected PdoDb $db;

  private function proceed(): void
  {
    $this->fileTemplateUrl = $this->getFileUrl(__DIR__, $this->class, $this->method);
    $this->modelClassPath = $this->getModeClassPath($this->class, $this->method);
  }
  public function getposts()
  {
    if (isset($_SESSION['user']) && $_SESSION['user']) {
      $this->toBlog();
    } else {
      $this->toMain();
    }
  }
  public function post()
  {
    $this->method = __METHOD__;
    $this->class = __CLASS__;
    $this->proceed();
  }
  public function removepost()
  {
    if (isset($_SESSION['user']) && $_SESSION['user']) {
      $this->method = __METHOD__;
      $this->class = __CLASS__;
      $this->proceed();
    } else {
      $this->toMain();
    }
  }
  public function postapi()
  {
    if (isset($_POST['user_id'])) {
      $this->method = __METHOD__;
      $this->class = __CLASS__;
      $this->proceed();
    } else {
      $this->toMain();
    }
  }
}
