<?php

namespace App\Controller;
use Src\PdoDb;
use Src\AbstractController;

class Blog extends AbstractController
{
  protected PdoDb $db;
  public function getposts()
  {
    if (isset($_SESSION['user']) && $_SESSION['user']) {
      $this->getLastPosts();
      $this->fileTemplateUrl = $this->getFileUrl(__DIR__, __CLASS__, __METHOD__);
      $this->modelClassPath = $this->getModeClassPath(__CLASS__, __METHOD__);
    } else {
      $this->goToMainPage();
    }
  }
  public function blog()
  {
    $this->fileTemplateUrl = $this->getFileUrl(__DIR__, __CLASS__, __METHOD__);
    $this->modelClassPath = $this->getModeClassPath(__CLASS__, __METHOD__);
  }
  public function removepost()
  {
    if (isset($_SESSION['user']) && $_SESSION['user']) {
      $this->fileTemplateUrl = $this->getFileUrl(__DIR__, __CLASS__, __METHOD__);
      $this->modelClassPath = $this->getModeClassPath(__CLASS__, __METHOD__);
    }
  }
  public function postapi()
  {
    if (isset($_POST['user_id'])) {
      $this->fileTemplateUrl = $this->getFileUrl(__DIR__, __CLASS__, __METHOD__);
      $this->modelClassPath = $this->getModeClassPath(__CLASS__, __METHOD__);
    } else {
      $this->goToMainPage();
    }
  }
}
