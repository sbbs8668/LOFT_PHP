<?php
namespace Src;

use Src\Traits;

use App\Controller\Traits as ControllerTraits;

use App\Model as Model;
use App\Model\Traits as ModelTraits;

use App\View\Traits as ViewFunctions;

abstract class AbstractController
{
  use Traits\Getsiteroot;

  use ControllerTraits\Redirects;

  use Model\Controller;
  use ModelTraits\GetModelClassPath;

  use ViewFunctions\GetTemplateUrl;
  use ViewFunctions\RenderSite;

  protected string $fileTemplateUrl;
  protected array $modelClassPath;

  protected string $class;
  protected string $method;
}
