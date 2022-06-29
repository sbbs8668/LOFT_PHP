<?php
namespace App\Model\Functions;
use Src\PdoDb;

trait Lastposts
{
  protected function getLastPosts(): void
  {
    $this->db = PdoDb::getInstance();
    $numberOfPosts = 20;
    $query = "
      SELECT 
          POSTS.`id`,
          POSTS.`text`,
          POSTS.`image`,
          POSTS.`date`,
          USERS.`id` as userID,
          USERS.`name` as userName
          FROM POSTS, USERS
          WHERE POSTS.`user` =   USERS.`id`
          AND NOT POSTS.`state` = 0
          ORDER BY POSTS.`id` DESC
          LIMIT $numberOfPosts        
      ";
    $result = $this->db->fetchAll($query, [], __METHOD__);
    $_SESSION['lastposts'] = json_encode($result);
  }
}
