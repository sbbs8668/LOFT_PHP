<?php
namespace App\Model\Blog;

use Src\AbstractModel;

const API_POSTS_NUMBER = 20;

class Postapi extends AbstractModel
{
  public function postapi(): void
  {
    if (isset($_POST['user_id'])) {
      $postsNumber = API_POSTS_NUMBER;
      $query = "
        SELECT 
            `id`,
            `user`,
            `text`,
            `image`,
            `date`
        FROM `posts`
        WHERE 
            `user` = :id
            AND NOT `state` = 0
        ORDER BY `date` LIMIT $postsNumber;";
      $parameters = [
        ':id' => (int)$_POST['user_id'],
      ];
      $posts = $this->db->fetchAll($query, $parameters, __METHOD__);
      echo(json_encode($posts));
      exit;
    }
  }
}
