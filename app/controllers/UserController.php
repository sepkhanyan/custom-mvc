<?php

namespace app\controllers;

use app\models\User;
use tm\core\base\View;

class UserController extends Controller
{
    public function login()
    {
        if (!empty($_POST)) {

            $user = new User();

            $login = !empty($_POST['login']) ? trim($_POST['login']) : null;

            $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
            if ($login) {
                $user = \R::findOne('users', 'login = ? LIMIT 1', [$login]);
                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        redirect();
                    }
                    $_SESSION['error'] = 'Your credentials does not match our records.';
                }
                $_SESSION['error'] = 'Your credentials does not match our records.';
            }
            redirect();
        }
    }

    public function logout()
    {
        if(isset($_SESSION['user_id'])){

            unset($_SESSION['user_id']);
        }
        redirect();
    }
}
