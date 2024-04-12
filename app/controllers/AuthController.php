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
        $_SESSION['navActive'] = 'login';

        self::loadView('client/user/login', [
            'error' => '',
            'registerStatus' => 'active'
        ]);
    }

    public static function getRegisterView()
    {
        $_SESSION['navActive'] = 'register';

        self::loadView('client/user/register', [
            'error' => '',
            'registerStatus' => 'active'
        ]);
    }

    // public static function getResetPasswordView()
    // {
    // }


    // Logic : 

    public static function login()
    {


        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            extract($_POST);
            $_SESSION['error'] = '';

            if (!empty($user_login) && !empty($user_password)) {
                $user = static::getModel()->where('user_login', $user_login);

                if (count($user) === 1) {
                    $user = $user[0];

                    // $pwdCheck = password_verify($user_password, $user['user_password']);
                    // if ($pwdCheck == true) {                     //? didnt work for some reason 

                    if ($user_password === $user['user_password']) {

                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['user_login_status'] = 'logged_in';

                        if ($user['user_role'] === 1) {
                            $_SESSION['authorized'] = 'yes';
                            header('location: index.php?adminAction=home');
                            exit();
                        } else {
                            // Welcome message for normal users only
                            $_SESSION['welcomeMessage'] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                                <strong>Welcome back!</strong> We missed you.
                                                           </div>';
                        }

                        session_regenerate_id(true); // pour des raisons de securité ?
                        header('location: index.php?action=home');
                        exit();
                    } else {
                        $_SESSION['error'] .= "<div class='alert alert-danger'>Invalid username or password</div>";
                    }
                } else {
                    $_SESSION['error'] .= "<div class='alert alert-danger'>Invalid username or password</div>";
                }
            } else {
                $_SESSION['error'] .= "<div class='alert alert-danger'>Username and password are required</div>";
            }
        }

        header('location: index.php?action=login');
    }


    public static function register()
    {


        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            extract($_POST);

            $_SESSION['error'] = "";
            if ($user_surname === "" || strlen($user_surname) > 20) $_SESSION['error'] .= "<div class='alert alert-danger'>Invalid name</div>";
            if (!isset($user_age) || $user_age < 18 || $user_age > 70) $_SESSION['error'] .= "<div class='alert alert-danger'>Invalid age</div>";
            if ($user_login === "" || strlen($user_login) > 30) $_SESSION['error'] .= "<div class='alert alert-danger'>Invalid username format</div>";
            if (strlen($user_password) < 7) $_SESSION['error'] .= "<div class='alert alert-danger'>Password too short</div>";


            //Checking uniqueness of login and password:
            if (count(static::getModel()->where('user_email', $user_email)) === 1) $_SESSION['error'] .= "<div class='alert alert-danger'>Email already used.</div>";
            if (count(static::getModel()->where('user_login', $user_login)) === 1) $_SESSION['error'] .= "<div class='alert alert-danger'>Login already used.</div>";

            if ($_SESSION['error'] == "") {
                // $hashedPassword = password_hash($user_password, PASSWORD_DEFAULT);

                $isCreated = static::getModel()
                    ->setUserEmail($user_email)
                    ->setUserAge($user_age)
                    ->setUserLogin($user_login)
                    ->setUserSurname($user_surname)
                    ->setUserPassword($user_password)
                    ->setUserRole(0)
                    ->addUser();
                if ($isCreated === true) {
                    $_SESSION['message'] = "<div class='alert alert-success'>You are now one of us 🥰 Check your mail to see a welcome message!</div>";
                    header('location: index.php?action=login');
                    exit();
                } else
                    $_SESSION['error'] .= "<div class='alert alert-danger'>A database problem occurred</div>";
            }
        }

        header('location: index.php?action=register');
    }

    public static function logout()
    {
        session_destroy();

        unset($_SESSION);

        // setcookie('user_login_status', '', time() - 3600);
        // unset($_COOKIE);

        header('location: index.php?action=home');
        exit();
    }

    // public static function forgotPassword()
    // {
    // }

    // public static function resetPassword()
    // {
    // }

    // public static function verifyEmail()
    // {
    // }
}
