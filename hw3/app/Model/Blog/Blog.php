<?php
namespace App\Model\Blog;

use Src\PdoDb;
use Src\AbstractModel;

const MISSING_TEXT_DATA_ERROR = 'Please, type something into the text field..';
const POSTED_OK = 'Your post has been succesfully posted!';

class Blog extends AbstractModel
{
  private int $user;
  private string $text;
  private string $image;

  public function blog()
  {
    if (isset($_POST['posttext']) && $_POST['posttext']) {
      print_r($_POST['posttext']);
      /*check if user from session really exists*/
      $userID = $_SESSION['id'];
      $user = json_decode($_SESSION['user'], true);
      $this->email = $user['email'];
      $check = $this->getExistedUser($userID);
      if ($check) {
        if ($_FILES['images']['tmp_name']) {
          $img = file_get_contents($_FILES['images']['tmp_name']);
          $img = $this->imageResize($img);
        }
        $this->user = $userID;
        $this->text = htmlspecialchars($_POST['posttext']);
        $this->image = $img ?? '';
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
          ':user' => $this->user,
          ':text' => $this->text,
          ':image' => $this->image,
          ':date' => time()
        ];
        $this->db->exec($query, $parameters, __METHOD__);
        unset($_POST);
        $_SESSION['errors'] = POSTED_OK;
      }
    } else {
      $_SESSION['errors'] = MISSING_TEXT_DATA_ERROR;
    }
  }
  private function imageResize($img): string
  {
    $im = imagecreatefromstring($img);
    $source_width = imagesx($im);
    $source_height = imagesy($im);
    (int)$ratio = $source_height / $source_width;
    $new_width = 400;
    (int)$new_height = $ratio * $new_width;
    $thumb = imagecreatetruecolor((int)$new_width, (int)$new_height);
    imagesavealpha($thumb, true);
    $background = imagecolorallocate($thumb, 255, 255, 255);
    $tp = '/jpeg';
    imagefill($thumb, 0, 0, $background);
    imagecopyresampled($thumb, $im, 0, 0, 0, 0, (int)$new_width, (int)$new_height, $source_width, $source_height);
    ob_start();
    imagejpeg($thumb, NULL, 90);
    $stringdata = ob_get_contents();
    ob_end_clean();
    $img = 'data:image' . $tp . ';base64, ' . base64_encode($stringdata);
    return $img;
  }
}
