<?php

namespace App\Controller;

use Src\AbstractController;

class _404 extends AbstractController
{
  public function _404()
  {
    $this->fileTemplateUrl = $this->getFileUrl(__DIR__, __CLASS__, __METHOD__);
    $this->modelClassPath = $this->getModeClassPath(__CLASS__, __METHOD__);
  }
}
