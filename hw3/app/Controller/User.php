<?php
namespace App\Controller;

use Src\AbstractController;

const REDIRECT_TO_BLOG_CLASS = 'App\\Model\\Blog';
const REDIRECT_TO_BLOG_METHOD = 'App\\Model\\Blog::getposts';

class User extends AbstractController
{
  private string $class;
  private string $method;

  private function proceed(): void
  {
    $this->fileTemplateUrl = $this->getFileUrl(__DIR__, $this->class, $this->method);
    $this->modelClassPath = $this->getModeClassPath($this->class, $this->method);
  }
  private function redirectToBlog(): void
  {
    $this->getLastPosts();
    $this->method = REDIRECT_TO_BLOG_METHOD;
    $this->class = REDIRECT_TO_BLOG_CLASS;
    $this->proceed();
  }
  public function login(): void{
    if (isset($_SESSION['user']) && $_SESSION['user']) {
      $this->redirectToBlog();
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
      $this->redirectToBlog();
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
