<?php

namespace App\Model\User;

use Src\Eloquent\Eloquent;
use Src\AbstractModel;
use App\Model\Traits\Images;

const MAX_NAME_LENGTH = 100;
const MIN_PSWD_LENGTH = 4;
const CHANGE_ERROR = 'Ooops.. something went wrong... Please try again!';
const EMPTY_FILEDS = 'Please change some your data!';
const CHANGE_CONFIRM = 'Your data has been successfully changed!';

class Changeuser extends AbstractModel
{
    use Images;
    public function changeuser()
    {
        $_SESSION['errors'] = CHANGE_ERROR;
        if (isset($_POST)) {
            $user = json_decode($_SESSION['user'], true);
            $userRole = $user['role'];
            if ($userRole) {
                $userID = $_SESSION['id'];
                $capsule = new Eloquent;
                $check = $capsule->getUserById($userID)[0]->id;
                if ($check === $userID) {
                    if (isset($_POST['removeavatar'])) {
                        $capsule->changeUserField($userID, 'avatar', '');
                        $user['avatar'] = '';
                        $_SESSION['user'] = json_encode($user);
                        $_SESSION['errors'] = CHANGE_CONFIRM;
                    } else {
                        $name = '';
                        $pswd = '';
                        $img = '';
                        if (isset($_POST['name']) && trim($_POST['name']) && strlen(trim($_POST['name'])) <= MAX_NAME_LENGTH){
                            $name = htmlspecialchars(trim($_POST['name']));
                            $capsule->changeUserField($userID, 'name', $name);
                            $user['name'] = $name;
                        }
                        if (strlen($_POST['pswd']) >= MIN_PSWD_LENGTH && $_POST['pswd'] === $_POST['pswdrep']) {
                            $pswd = $this->makePswd();
                            $capsule->changeUserField($userID, 'pswd', $pswd);
                        }
                        if (isset($_FILES['avatar']) && $_FILES['avatar']['tmp_name']) {
                            $img = file_get_contents($_FILES['avatar']['tmp_name']);
                            $img = $this->imageResize($img);
                            $capsule->changeUserField($userID, 'avatar', $img);
                            $user['avatar'] = $img;
                        }
                        if (!$name && !$pswd && !$img) {
                            $_SESSION['errors'] = EMPTY_FILEDS;
                        } else {
                            $_SESSION['user'] = json_encode($user);
                            $_SESSION['errors'] = CHANGE_CONFIRM;
                        }
                    }
                    $this->toBlog();
                }
            }
        }
        $this->toBlog();
    }
}
