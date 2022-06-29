<?php
namespace Src;
use App\View\Functions as ViewFunctions;
use App\Model\Functions as ModelFunctions;

abstract class AbstractController
{
  use ModelFunctions\Lastposts;
  use ModelFunctions\GetModelClassPath;
  use ModelFunctions\ModelSite;
  use ViewFunctions\GetTemplateUrl;
  use ViewFunctions\RenderSite;
  protected string $fileTemplateUrl;
  protected array $modelClassPath;
  protected function goToMainPage()
  {
    header('Location: '. trim(file_get_contents(__DIR__. '/pathtoroot.txt')));
  }
}
