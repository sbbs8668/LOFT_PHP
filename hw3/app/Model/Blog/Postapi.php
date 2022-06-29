<?php
namespace App\Model\Blog;

use Src\PdoDb;
use Src\AbstractModel;

class Postapi extends AbstractModel
{
  protected PdoDb $db;
  public function postapi():void
  {
    /*check if user is admin*/
    if (isset($_POST['user_id'])) {
      $postsNumder = 20;
      $query = "SELECT * FROM `posts` WHERE `user` = :id ORDER BY `date` LIMIT $postsNumder;";
      $parameters = [
        ':id' => (int)$_POST['user_id'],
      ];
      $this->db = PdoDb::getInstance();
      $posts = $this->db->fetchAll($query, $parameters, __METHOD__);
      echo(json_encode($posts));
      exit;
    }
  }
}
