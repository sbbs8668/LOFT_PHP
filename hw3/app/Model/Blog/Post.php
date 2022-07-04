<?php
namespace App\Model\Blog;

use Src\AbstractModel;
use App\Model\Traits\Images;

const MISSING_TEXT_DATA_ERROR = 'Please, type something into the text field..';
const POSTED_OK = 'Your post has been successfully posted!';

class Post extends AbstractModel
{
  use Images;
  public function post()
  {
    if (isset($_POST['posttext']) && $_POST['posttext']) {
      /*check if user from session really exists*/
      $userID = $_SESSION['id'];
      $user = json_decode($_SESSION['user'], true);
      $email = $user['email'];
      $check = $this->getExistedUser($email, $userID);
      if ($check) {
        if ($_FILES['images']['tmp_name']) {
          $img = file_get_contents($_FILES['images']['tmp_name']);
          $img = $this->imageResize($img);
        }
        $user = $userID;
        $text = htmlspecialchars($_POST['posttext']);
        /*$this->image = $img ?? '';*/
        $query = "
          INSERT INTO
              `posts`(
                `user`,
                `text`,
                `image`,
                `date`
              )
          VALUES (:user, :text, :image, :date);
        ";
        $parameters = [
          ':user' => $user,
          ':text' => $text,
          ':image' => $img ?? '',
          ':date' => time()
        ];
        $this->db->exec($query, $parameters, __METHOD__);
        unset($_POST);
        $_SESSION['errors'] = POSTED_OK;
      } else {
        exit;
      }
    } else {
      $_SESSION['errors'] = MISSING_TEXT_DATA_ERROR;
    }
  }
}
