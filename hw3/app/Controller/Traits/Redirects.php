<?php
namespace App\Controller\Traits;

const REDIRECT_TO_BLOG_CLASS = 'App\\Model\\Blog';
const REDIRECT_TO_BLOG_METHOD = 'App\\Model\\Blog::getposts';

trait Redirects
{
  protected function toBlog(): void
  {
    $this->method = REDIRECT_TO_BLOG_METHOD;
    $this->class = REDIRECT_TO_BLOG_CLASS;
  }

  protected function toMain(): void
  {
    header('Location: '. $this->getRoot());
    exit;
  }

  protected function reloadSite(): void
  {
    header("Refresh:0");
    exit;
  }
}
