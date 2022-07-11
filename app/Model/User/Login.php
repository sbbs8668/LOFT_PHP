<?php
namespace App\Model\User;

use Src\AbstractModel;

const USER_REGISTER_TEMPORARY_CONFIRM = 100000;
const MISSING_LOGIN_DATA_ERROR = 'Fill in all fields, please.';
const BASIC_LOGIN_ERROR = 'Ooops.. something went wrong... Please try again!';

class Login extends AbstractModel
{
  private int $id = 0;
  private string $email = '';
  private string $pswd = '';

  public function login()
  {
    if (isset($_SESSION['confirm']) && $_SESSION['confirm'] === USER_REGISTER_TEMPORARY_CONFIRM) {
          $_SESSION['confirm'] = 0;
          $_SESSION['error'] = '';
    }

    /*check if it is already logged in with session*/
    if (isset($_SESSION['id']) && is_numeric($_SESSION['id']) && $_SESSION['id']) {
      $this->id = $_SESSION['id'];
    }

    if ($this->id) {
      /*it will log in from session and redirect to the blog*/
      $this->loginFromSession();
    } else {
      $this->loginFromPOST();
    }
  }
  private function loginFromSession()
  {
    /*if SESSION['user'] is set it has already redirected to Blog in Controller\User, no need to repeat it here*/
    /*if (isset($_SESSION['user']) && $_SESSION['user']) {}*/
    /*if it gets here that means SESSION['id'] is set, $_SESSION['user'] is not */
    $query = "
        SELECT `name`, `email`, `regdate` 
        FROM `users`
        WHERE 
            `id` = :id
        AND `confirm` = 1
    ;";
    $parameters = [
      ':id' => $this->id
    ];
    $user = $this->db->fetchOne($query, $parameters, __METHOD__);
    if ($user) {
      $user = json_encode($user);
      $_SESSION['user'] = $user;
      /*when $_SESSION['user'] is set and the page reloads it redirects to the Blog here: Controller\User*/
      $this->reloadSite();
    } else {
      $_SESSION['errors'] = BASIC_LOGIN_ERROR;
    }
  }
  private function loginFromPOST()
  {
    if($_POST){
      if (
        !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ||
        !$_POST['pswd']
      ) {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['errors'] = MISSING_LOGIN_DATA_ERROR;
      } else {
        /*it will come here after the log in form is sent*/
        $this->clearErrors();
        $this->email = $_POST['email'];
        $this->pswd = $this->makePswd();
        $this->loginByEmail();
      }
    }
    /*if theres no session and the login form has not been sent yet the login page is shown*/
  }
  private function loginByEmail()
  {
    $query = "
        SELECT `id`, `name`, `regdate`, `role`
        FROM `users`
        WHERE 
            `email` = :email AND
            `pswd` = :pswd
        AND `confirm` = 1
    ;";
    $parameters = [
      ':email' => $this->email,
      ':pswd' => $this->pswd,
    ];
    $user = $this->db->fetchOne($query, $parameters, __METHOD__);
    if ($user) {
      $_SESSION['id'] = $user['id'];
      $user['email'] = $this->email;
      $user = json_encode($user);
      $_SESSION['user'] = $user;
      $_SESSION['errors'] = '';
      $this->reloadSite();
    } else {
      $_SESSION['email'] = $this->email;
      $_SESSION['errors'] = BASIC_LOGIN_ERROR;
    }
  }
}
