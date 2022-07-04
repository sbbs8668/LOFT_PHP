<?php
namespace App\Model\User;
use Src\AbstractModel;

class Signout extends AbstractModel
{
 /* public function __construct()
  {
  }*/
  public function signout()
  {
    session_destroy();
  }
}
