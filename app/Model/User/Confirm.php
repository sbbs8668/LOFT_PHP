<?php
namespace App\Model\User;

use Src\AbstractModel;
const BASIC_CONFIRM_ERROR = 'Ooops.. something went wrong... Please try again!';

class Confirm extends AbstractModel
{
  public function confirm()
  {
    if(!isset($_POST) ||  !isset($_POST['pincode']) || !$_POST['pincode']) {
      /*get back to register page*/
      $this->getBackToRegister();
    }
    /*validate user*/
    $user = $this->getExistedUser('', (int)$_SESSION['id'], (int)$_POST['pincode']);
    /*print_r($user);*/
    if ($user) {
      $query = "
        UPDATE
            `users`
        SET
            `confirm` = 1
        WHERE `id` = :id
      ";
      $this->db->exec($query, [':id' => (int)$_SESSION['id']], __METHOD__);
      $_SESSION['id'] = (int)$_SESSION['id'];
      unset($user['confirm']);
      $user['avatar'] = '';
      $_SESSION['user'] = json_encode($user);
      $_SESSION['confirm'] = 1;
      $_SESSION['errors'] = '';
      $this->toMain();
      exit;
    } else {
      /*get back to register page*/
      $this->getBackToRegister();
    }
  }
  private function getBackToRegister(): void
  {
    $_SESSION['errors'] = BASIC_CONFIRM_ERROR;
    header('Location: '. $this->getRoot() . 'user/register');
    exit;
  }
}
