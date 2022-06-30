<?php
namespace Src;
use App\View\Functions as ViewFunctions;
use App\Model\Functions as ModelFunctions;

abstract class AbstractController
{
  use Getsiteroot;
  use ModelFunctions\Lastposts;
  use ModelFunctions\GetModelClassPath;
  use ModelFunctions\ModelSite;
  use ViewFunctions\GetTemplateUrl;
  use ViewFunctions\RenderSite;
  protected string $fileTemplateUrl;
  protected array $modelClassPath;
  protected function goToMainPage(): void
  {
    header('Location: '. trim(file_get_contents(__DIR__. '/pathtoroot.txt')));
  }
}
