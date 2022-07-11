<?php

namespace App\View\Traits;

trait RenderSite
{
  public function rendersite(): void
  {
    $pathToSite = $this->getRoot();
    $css = '<link href="' . $pathToSite . 'css.css" rel="stylesheet">';
    $js = '<script src="' . $pathToSite . 'js.js" type="text/javascript"></script>';
    if (isset($this->fileTemplateUrl)) {
      if (file_exists($this->fileTemplateUrl)) {
        ob_start();
        echo '<head>';
        echo $css;
        echo '</head>';
        include $this->fileTemplateUrl;
        echo $js;
        echo ob_get_clean();
        $_SESSION['errors'] = '';
      } else {
        $this->toMain();
      }
    }
  }
}
