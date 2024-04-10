<?php

//handles touskié auth fa9at

require_once 'app/libs/Controller.php';
require_once 'app/models/UserModel.php';

class AuthController extends Controller
{
    private static $userModel;

    public static function getModel(): UserModel
    {
        if (is_null(self::$userModel))
            self::$userModel = new UserModel();
        return self::$userModel;
    }


    // Getting views :

    public static function getLoginView()
    {
        self::loadView('client/user/login', [
            'errors' => '',
            'registerStatus' => 'active'
        ]);
    }

    public static function getRegisterView()
    {
        self::loadView('client/user/register', [
            'errors' => '',
            'registerStatus' => 'active'
        ]);
    }

    public static function getResetPasswordView()
    {
    }
    //Etc.


    // Logic : 

    public static function login()
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            extract($_POST);
            $errors = '';

            if (!empty($user_login) && !empty($user_password)) {
                $user = static::getModel()->where('user_login', $user_login);

                if (count($user) === 1) {
                    $user = $user[0];

                    if ($user['user_password'] === $user_password) {
                        if ($user['user_role'] === 1) {
                            $_SESSION['admin'] = $user('user_id');
                            setcookie('user_login_status', 'logged_in', time() + (24 * 60 * 60));
                        }

                        $_SESSION['user_login_status'] = 'logged_in';
                        $_SESSION['welcome_message_shown'] = true;
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['message'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <strong>Welcome back!</strong> We missed you.
                                                </div>';

                        setcookie('user_login_status', 'logged_in', time() + (24 * 60 * 60));

                        header('location: index.php?action=home');
                    } else {
                        $errors .= "<div class='alert alert-danger'>Invalid username or password</div>";
                    }
                } else {
                    $errors .= "<div class='alert alert-danger'>Invalid username or password</div>";
                }
            } else {
                $errors .= "<div class='alert alert-danger'>Username and password are required</div>";
            }

            static::loadView('client/user/login', ['errors' => $errors]);
        } else {
            header('location: index.php?action=login');
        }
    }


    public static function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            extract($_POST);

            $errors = "";
            if ($user_surname === "" || strlen($user_surname) > 20) $errors .= "<div class='alert alert-danger'>Invalid name</div>";
            if ($user_age < 18 || $user_age > 70) $errors .= "<div class='alert alert-danger'>Invalid age</div>";
            if ($user_login === "" || strlen($user_login) > 30) $errors .= "<div class='alert alert-danger'>Invalid username format</div>";
            if (strlen($user_password) < 10) $errors .= "<div class='alert alert-danger'>Password too short</div>";

            //Checking uniqueness of login and password:
            if (count(static::getModel()->where('user_email', $user_email)) === 1) $errors .= "<div class='alert alert-danger'>Email already used.</div>";
            if (count(static::getModel()->where('user_login', $user_login)) === 1) $errors .= "<div class='alert alert-danger'>Login already used.</div>";

            if ($errors == "") {
                $isCreated = static::getModel()
                    ->setUserEmail($user_email)
                    ->setUserAge($user_age)
                    ->setUserLogin($user_login)
                    ->setUserSurname($user_surname)
                    ->setUserPassword($user_password)
                    ->setUserRole(0)
                    ->addUser();
                if ($isCreated === true) {
                    header('location: index.php?action=login');
                } else
                    $errors .= "<div class='alert alert-danger'>A database problem occurred</div>";
            }
            static::loadView('client/user/register', ['errors' => $errors]);
        }
    }

    public static function logout()
    {
        session_destroy();

        unset($_SESSION);

        setcookie('user_login_status', '', time() - 3600);
        unset($_COOKIE);

        header('location: index.php?action=login');
        exit();
    }

    public static function forgotPassword()
    {
        // Logic for handling password reset requests
    }

    public static function resetPassword()
    {
        // Logic for resetting the user's password
    }

    public static function verifyEmail()
    {
        // Logic for verifying the user's email for account activation
    }
}
