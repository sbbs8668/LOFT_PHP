<?php

namespace App\Model\User;

use Src;
use Src\AbstractModel;
use Src\Eloquent\Eloquent;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

const EMAIL_ERROR = 'Please enter your email address.';
const RECOVER_ERROR = 'Ooops.. something went wrong... Please try again!';
const RECOVER_MESSAGE = 'Your new password is:';
const RECOVER_SUBJECT = 'Here is your new password';
const RECOVER_CONFIRM = 'Your password has been successfully changed!';

class Recoverpasswd extends AbstractModel
{
    use Src\Mailsender;

    private string $email;
    protected object $capsule;

    public function recoverpasswd(): void
    {
        $_SESSION['errors'] = '';

        if (!isset($_SESSION['recoverypsswd'])) {
            if (isset($_POST['recoveryemail'])) {
                $this->email = trim($_POST['recoveryemail']);
                if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    $this->capsule = new Eloquent;
                    $this->recoverStep1();
                } else {
                    $this->showError(EMAIL_ERROR);
                }
            }
        }

        if (isset($_SESSION['recoverypsswd']) && isset($_SESSION['recoveryid'])) {
            if (isset($_POST['recoverypsswd'])) {
                if ($_SESSION['recoverypsswd'] === $_POST['recoverypsswd']) {
                    $this->capsule = new Eloquent;
                    $this->recoverStep2();
                } else {
                    $this->showError(RECOVER_ERROR);
                }
            }
        }
    }
    private function recoverStep1(): void
    {
        $user = $this->capsule->getUserByEmail($this->email);
        if (isset($user[0]) && $user[0]->email === $this->email) {
            $newPsswd = bin2hex(openssl_random_pseudo_bytes(rand(4, 6)));
            $_SESSION['recoverypsswd'] = $newPsswd;
            $_SESSION['recoveryid'] = $user[0]->id;
            $recoverMessage = RECOVER_MESSAGE . ' ' .$newPsswd;
            try {
                $this->sendEmail($this->email, RECOVER_SUBJECT, $recoverMessage);
                $this->reloadSite();
            } catch (TransportExceptionInterface $e) {
                $this->showError(RECOVER_ERROR);
            }
        } else {
            $this->showError(RECOVER_ERROR);
        }
    }
    private function recoverStep2(): void
    {
        $pswd = $this->makePswd($_SESSION['recoverypsswd']);
        if ($this->capsule->changeUserPassword($_SESSION['recoveryid'], $pswd)) {
            $user = (array)$this->capsule->getUserById($_SESSION['recoveryid'])[0];
            $_SESSION['id'] = $_SESSION['recoveryid'];
            unset($user['id']);
            unset($user['pswd']);
            unset($_SESSION['recoveryid']);
            unset($_SESSION['recoveryid']);
            $_SESSION['user'] = json_encode($user);
            $_SESSION['confirm'] = 1;
            $_SESSION['errors'] = RECOVER_CONFIRM;
            $this->toMain();
            exit;
        }
    }
    private function showError($error): void
    {
        $this->email = '';
        unset($this->capsule);
        unset($_POST['recoveryemail']);
        $_SESSION['errors'] = $error;
    }
}
