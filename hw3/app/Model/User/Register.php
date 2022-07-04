<?php
namespace App\Model\User;
use Src\PdoDb;
use Src\AbstractModel;

const MAX_NAME_LENGTH = 100;
const MAX_EMAIL_LENGTH = 100;
const MISSING_REGISTER_DATA_ERROR = 'Please, check your data nad fill in all fields.';
const BASIC_REGISTER_ERROR = 'Ooops.. something went wrong... Please try again!';

class Register extends AbstractModel
{
  private int $error;
  private string $name;
  protected string $email;
  private string $pswd;

  private function validateData(): void
  {
    $this->error = 0;
    $this->name = '';
    $this->email = '';
    $this->pswd = '';

    if ($_POST['name']) {
      if (strlen($_POST['name']) > MAX_NAME_LENGTH){
        $this->error = 1;
      } else {
        $this->name = htmlspecialchars(trim($_POST['name']));
      }
    }
    if (filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
      if (strlen($_POST['email']) > MAX_EMAIL_LENGTH){
        $this->error = 1;
      } else {
        $this->email = $_POST['email'];
      }
    }
    if (strlen($_POST['pswd']) >= 4 && $_POST['pswd'] === $_POST['pswdrep']) {
      $this->pswd = $this->makePswd();
    } else {
      $this->error = 1;
    }
    if (!$this->name || !$this->email || !$this->pswd) {
      $this->error = 1;
    }
  }
  private function showError(string $error): void
  {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['pswd'] = $_POST['pswd'];
    $_SESSION['errors'] = $error;
  }
  public function register()
  {
    if ($_POST) {
      /*validate data*/
      $this->validateData();
      if (!$this->error) {
        /*without id checks by email and returns '' if theres no user with this email*/
        if($this->getExistedUser()) {
          $this->showError(BASIC_REGISTER_ERROR);
        } else {
          /*ok insert*/
          $query = "
            INSERT INTO
                `users`(
                  `name`,
                  `email`,
                  `pswd`,
                  `regdate`
                )
            VALUES (:name, :email, :pswd, :regdate);
          ";
          $parameters = [
            ':name' => $this->name,
            ':email' => $this->email,
            ':pswd' => $this->pswd,
            ':regdate' => time()
          ];
          $this->db->exec($query, $parameters, __METHOD__);
          $newUserID = $this->db->getLastId();
          $checkNewUser = $this->getExistedUser($this->email, $newUserID);
          /*with id checks by id and email and returns array if new user is ok*/
          if(!$checkNewUser) {
            $this->showError(BASIC_REGISTER_ERROR);
          } else {
            $_SESSION['id'] = $newUserID;
            $_SESSION['user'] = json_encode($checkNewUser);
            $this->reloadSite();
            exit;
          }
        }
      } else {
        $this->showError(MISSING_REGISTER_DATA_ERROR);
      }
    }
  }
}
