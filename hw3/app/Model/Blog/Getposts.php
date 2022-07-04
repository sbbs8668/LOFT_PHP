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
          POSTS.`id`,
          POSTS.`text`,
          POSTS.`image`,
          POSTS.`date`,
          USERS.`id` as userID,
          USERS.`name` as userName
      FROM POSTS, USERS
      WHERE POSTS.`user` = USERS.`id`
      AND NOT POSTS.`state` = 0
      ORDER BY POSTS.`id` DESC
      LIMIT $numberOfPosts        
    ";
    $result = $this->db->fetchAll($query, [], __METHOD__);
    $_SESSION['lastposts'] = json_encode($result);
  }
}
