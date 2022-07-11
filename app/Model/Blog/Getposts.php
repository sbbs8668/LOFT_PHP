<?php
namespace App\Model\Blog;

use Src\AbstractModel;

const BLOG_POSTS_NUMBER = 20;

class Getposts extends AbstractModel
{
  public function getposts(): void
  {
    $numberOfPosts = BLOG_POSTS_NUMBER;
    $query = "
      SELECT 
          posts.`id`,
          posts.`text`,
          posts.`image`,
          posts.`date`,
          users.`id` as userID,
          users.`name` as userName
      FROM posts, users
      WHERE posts.`user` = users.`id`
      AND NOT posts.`state` = 0
      ORDER BY posts.`id` DESC
      LIMIT $numberOfPosts        
    ";
    $result = $this->db->fetchAll($query, [], __METHOD__);
    $_SESSION['lastposts'] = json_encode($result);
  }
}
