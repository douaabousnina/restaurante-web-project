<?php
//handles user-related actions like profile management, updating user information, etc..

require_once 'app/libs/Controller.php';
require_once 'app/models/UserModel.php';

class UsersController extends Controller
{

    private static $userModel;

    public static function getModel(): UserModel
    {
        if (is_null(static::$userModel))
            static::$userModel = new UserModel();
        return static::$userModel;
    }


    public static function indexAdmin()
    {
        $_SESSION['navActive'] = 'users';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // Pour le tri 
            if (isset($_POST['column'])) {
                $users = self::getModel()->showAllUsers($_POST['column']);
            }
        } else
            $users = static::getModel()->showAllUsers(); //tri selon le ID par défaut
        self::loadView('admin/users/users', ['users' => $users]);
    }


    public static function profile()
    {
        $_SESSION['navActive'] = 'orders';

        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['user_id'])) {
            $user = self::getModel()->showUser($_GET['user_id']);
            if ($user == false) {
                $_SESSION['error'] = '<div class="alert alert-danger">User not found</div>';
            }
            self::loadView('admin/users/userProfile', [
                'user' => $user
            ]);
            exit();
        }
        header('location: index.php?adminAction=orders');
    }


    public static function edit()
    {

        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['user_id'])) {
            $user = self::getModel()->showUser($_GET['user_id']);

            if ($user == false) {
                $_SESSION['error'] = '<div class="alert alert-danger">User not found</div>';
            }

            if (isset($_GET['adminAction'])) {                // Aperçu de edit user de l'admin

                $_SESSION['navActive'] = 'users';

                self::loadView('admin/users/editUser', [
                    'user' => $user
                ]);
                exit();
            }

            if (isset($_GET['action'])) {                    //Aperçu de edit user d'un utilisateur normal

                $_SESSION['navActive'] = 'myAccount';

                self::loadView('client/user/account', [
                    'myAccountStatus' => 'active', //! a revoir
                    'user' => $user
                ]);
                exit();
            }
        }
        header('location: index.php?action=home');
    }



    private static function verifyUser($data)
    {
        extract($data);

        $_SESSION['error'] = "";
        if ($user_surname === "" || strlen($user_surname) > 20) $_SESSION['error'] .= "<div class='alert alert-danger'>Invalid name</div>";
        if (!isset($user_age) || $user_age < 18 || $user_age > 70) $_SESSION['error'] .= "<div class='alert alert-danger'>Invalid age</div>";
        if ($user_login === "" || strlen($user_login) > 30) $_SESSION['error'] .= "<div class='alert alert-danger'>Invalid username format</div>";

        if (isset($data['user_password'])) {
            if (strlen($user_password) < 7) $_SESSION['error'] .= "<div class='alert alert-danger'>Password too short</div>";
        }

        //Checking uniqueness of login and email:
        // if (count(static::getModel()->where('user_email', $user_email)) === 1) $_SESSION['error'] .= "<div class='alert alert-danger'>Email already used.</div>";
        // if (count(static::getModel()->where('user_login', $user_login)) === 1) $_SESSION['error'] .= "<div class='alert alert-danger'>Login already used.</div>";

        if (isset($data['confirm_password'])) {            // Confirmation du mot de passe (pour user)
            if ($user_password !== $confirm_password)
                $_SESSION['error'] = '<div class="alert alert-danger">Not the same password.</div>';

            else {
                $user = self::getModel()->showUser($_GET['user_id']);
                if ($user['user_password'] !== $user_password) {
                    $_SESSION['error'] = '<div class="alert alert-danger">Incorrect password.</div>';
                }
            }
        }
    }


    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_GET['user_id'])) {
            extract($_POST);

            $user_role = isset($_POST['user_role']) && $_POST['user_role'] === 'user' ? 0 : 1;

            self::verifyUser($_POST);

            if ($_SESSION['error']==="") {
                $isUpdated = static::getModel()
                    ->setUserEmail($user_email)
                    ->setUserAge($user_age)
                    ->setUserLogin($user_login)
                    ->setUserSurname($user_surname)
                    ->setUserRole($user_role)
                    ->updateUser($_GET['user_id']);
                if ($isUpdated == true) {
                    $_SESSION['message'] = "<div class='alert alert-success'>User info updated successfully.</div>";
                } else {
                    $_SESSION['error'] = '<div class="alert alert-danger">Cannot update user info.</div>';
                }
            }
        }

        $user = self::getModel()->showUser($_GET['user_id']);

        if (isset($_GET['adminAction'])) {
            self::loadView('admin/users/editUser', [
                'user' => $user
            ]);
            exit();
        } else {
            self::loadView('client/user/account', [
                'user' => $user
            ]);
        }
    }


    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['user_id'])) {
            $isDeleted = static::getModel()->deleteUser($_GET['user_id']);
            if ($isDeleted === true)
                $_SESSION['message'] = "<div class='alert alert-danger'>User deleted successfully.</div>";
            else
                $_SESSION['error'] .= '<div class="alert alert-danger">Cannot delete user info.</div>';
        }

        if (isset($_GET['adminAction'])) //if the admin deletes a user
        {
            header('location: index.php?adminAction=users');
            exit();
        }
        // if the user deletes his account
        header('location: index.php?action=home');
    }
}
