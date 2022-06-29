<?php
namespace App\Model\User;
use Src\PdoDb;
use Src\AbstractModel;

class Changerole extends AbstractModel
{
  public function __construct()
  {
  }
  public function changerole()
  {
    if (isset($_POST['changerole'])) {
      $this->db = PdoDb::getInstance();
      $user = json_decode($_SESSION['user'], true);
      $userID = $_SESSION['id'];
      $userRole = $user['role'] ? 0 : 1;
      $userEmail = $user['email'];
      if ($userEmail && $userID) {
        $query = "
          UPDATE `users`
          SET `role` = :role
          WHERE `id` = :id AND `email` = :email
        ";
        $parameters = [
          ':role' => $userRole,
          ':id' => $userID,
          ':email' => $userEmail,
        ];
        $this->db->exec($query, $parameters, __METHOD__);
      }
      $user['role'] = $userRole;
      $_SESSION['user'] = json_encode($user);
      unset($_POST);
      $this->reloadSite();
      exit;
    }
  }
}
