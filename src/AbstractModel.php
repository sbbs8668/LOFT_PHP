<?php
namespace Src;

use Src\Traits;
use App\Controller\Traits as ControllerTraits;
use App\Model\Traits as ModelTraits;

abstract class AbstractModel
{
  protected PdoDb $db;
  public function __construct()
  {
    $this->db = PdoDb::getInstance();
  }
  use Traits\Getsiteroot;
  use Traits\Getsalt;
  use Traits\Makepswd;
  use Traits\Clearerrors;
  use ControllerTraits\Redirects;
  use ModelTraits\GetUser;
}
