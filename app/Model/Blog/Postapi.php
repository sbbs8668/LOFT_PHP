<?php
namespace App\Model\Blog;

use Src\AbstractModel;

const API_POSTS_NUMBER = 20;

class Postapi extends AbstractModel
{
  public function postapi(): void
  {
    if (file_get_contents('php://input')) {
          $img = json_decode(file_get_contents('php://input'));
      } else {
          $img = [];
      }
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
    } elseif (isset($img[0]) && $img[0] === 'img') {
        if (isset($_SESSION['lastpostsImages'])) {
            echo $_SESSION['lastpostsImages'];
        } else {
            echo '';
        }
        exit;
    } else {
        echo '';
        exit;
    }
  }
}
