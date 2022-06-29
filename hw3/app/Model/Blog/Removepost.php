<?php
namespace App\Model\Blog;

use Src\PdoDb;
use Src\AbstractModel;

const SUBMIT_BUTTON_TEXT = 'submit';
const POST_DELETED_OK = 'The post has been successfully deleted!';

class Removepost extends AbstractModel
{
  protected PdoDb $db;
  public function removepost():void
  {
    foreach ($_POST as $button => $a) {
      $postId = (int)str_replace(SUBMIT_BUTTON_TEXT, '', $button);
    }
    /*check if user is admin*/
    if (isset($_SESSION['id'])) {
      $userId = $_SESSION['id'];
      $query = "SELECT `role` FROM `users` WHERE `id` = :id;";
      $parameters = [
        ':id' => $userId ,
      ];
      $this->db = PdoDb::getInstance();
      $user = $this->db->fetchOne($query, $parameters, __METHOD__);
      if ($user['role'] === 1) {
        $query = "UPDATE `posts` SET `state` = 0 WHERE `id` = :id;";
        $parameters = [
          ':id' => $postId ,
        ];
        $this->db->exec($query, $parameters, __METHOD__);
        $_SESSION['errors'] = POST_DELETED_OK;
      }
    }
  }
}
