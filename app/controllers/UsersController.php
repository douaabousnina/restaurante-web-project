<?php
//handles user-related actions like profile management, updating user information, etc.

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['column'])) {
                $users = self::getModel()->showAllUsers($_POST['column']);
            }
        } else
            $users = static::getModel()->showAllUsers();
        self::loadView('admin/users/users', ['users' => $users]);
    }


    public static function profile()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['user_id'])) {
            $user = self::getModel()->showUser($_GET['user_id']);
            if ($user == false) {
                $_SESSION['error'] = 'User not found';
            }
            self::loadView('admin/users/userProfile', [
                'user' => $user
            ]);
            exit();
        }
        header('location: index.php?adminAction=users');
    }


    public static function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['user_id'])) {
            $user = self::getModel()->showUser($_GET['user_id']);
            if ($user == false) {
                $_SESSION['error'] = 'User not found';
            }
            if (isset($_GET['adminAction'])) {
                self::loadView('admin/users/editUser', [
                    'user' => $user
                ]);
                exit();
            } else
                self::loadView('client/user/account', [
                    'myAccountStatus' => 'active',
                    'user' => $user
                ]);
        } header('location: index.php?action=home');
    }


    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_GET['user_id'])) {
            extract($_POST);
            $user_role = isset($_POST['user_role']) && $_POST['user_role'] === 'user' ? 0 : 1;

            if (isset($_POST['confirm_password'])) {
                if ($user_password != $confirm_password)
                    $_SESSION['error'] = 'Not the same password.';
                else {
                    $user = self::getModel()->showUser($_GET['user_id']);
                    if ($user['user_password'] != $user_password) {
                        $_SESSION['error'] = 'Incorrect password.';
                    }
                }
                exit();
            }

            $isUpdated = static::getModel()
                ->setUserEmail($user_email)
                ->setUserAge($user_age)
                ->setUserLogin($user_login)
                ->setUserSurname($user_surname)
                ->setUserRole($user_role)
                ->updateUser($_GET['user_id']);

            if ($isUpdated === true)
                $_SESSION['message'] = "User info updated successfully.";
            else
                $_SESSION['error'] = 'Cannot update user info.';
        }
        if (isset($_GET['adminAction']))
            header('location: index.php?adminAction=user');
        else
            header('location: index.php?action=home');
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['user_id'])) {
            $isDeleted = static::getModel()->deleteUser($_GET['user_id']);
            if ($isDeleted === true)
                $_SESSION['message'] = "User deleted successfully.";
            else
                $_SESSION['error'] = 'Cannot delete user.';
        }
        header('location: index.php?adminAction=users');
    }
}
