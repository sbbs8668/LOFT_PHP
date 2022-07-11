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
          users.`name` as userName,
          users.`avatar` as userAvatar
      FROM posts, users
      WHERE posts.`user` = users.`id`
      AND NOT posts.`state` = 0
      ORDER BY posts.`id` DESC
      LIMIT $numberOfPosts        
    ";
    $result = $this->db->fetchAll($query, [], __METHOD__);
    $_SESSION['lastpostsImages'] = [];
    foreach ($result as &$post) {
        if ($post['image']) {
            $_SESSION['lastpostsImages'][$post['id']]['image'] = $post['image'];
        }
        if ($post['userAvatar']) {
            $_SESSION['lastpostsImages'][$post['id']]['avatar'] = $post['userAvatar'];
        }
        unset($post['image']);
        unset($post['userAvatar']);
    }
    $_SESSION['lastpostsImages'] = json_encode($_SESSION['lastpostsImages']);
    $_SESSION['lastposts'] = json_encode($result);
  }
}
