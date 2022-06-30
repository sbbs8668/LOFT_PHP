<?php

namespace App\View\Functions;

trait RenderSite
{
  public function rendersite(): void
  {
    $pathToSite = $this->gettroot();
    $css = '<head><link href="' . $pathToSite . 'css.css" rel="stylesheet"></head>';
    if (isset($this->fileTemplateUrl)) {
      if (file_get_contents($this->fileTemplateUrl)) {
        ob_start();
        echo $css;
        include $this->fileTemplateUrl;
        echo ob_get_clean();
        $_SESSION['errors'] = '';
      } else {
        header('Location: '. $pathToSite);
      }
    }
  }
}
