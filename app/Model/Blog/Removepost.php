<?php
namespace App\Model\Blog;

use Src\AbstractModel;

const SUBMIT_BUTTON_TEXT = 'submit';
const POST_DELETED_OK = 'The post has been successfully deleted!';

class Removepost extends AbstractModel
{
  public function removepost():void
  {
    foreach ($_POST as $button => $a) {
      $postId = (int)str_replace(SUBMIT_BUTTON_TEXT, '', $button);
    }
    if (!isset($postId) || !$postId) {
      return;
    }
    /*check if user is admin*/
    if (isset($_SESSION['id'])) {
      $user = $this->getExistedUser('', $_SESSION['id']);
      if ($user['role'] === 1) {
        $query = "UPDATE `posts` SET `state` = 0 WHERE `id` = :id;";
        $parameters = [
          ':id' => $postId,
        ];
        $this->db->exec($query, $parameters, __METHOD__);
        $_SESSION['errors'] = POST_DELETED_OK;
      }
    }
  }
}
