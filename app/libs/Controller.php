<?php

class Controller
{



    public static function newModel($model)
    {
        require_once "app/models/" . $model . ".php";
        return new $model();
    }

    public static function loadView($view, $data = [])
    {
        if (file_exists('app/views/' . $view . '.php')) {
            if (!is_null($data)) extract($data);

            // Pour verifier si on a 'register' or 'my account et logout'   (user *ordinaire* interface)
            $navElement = ' <li class="nav-item <?=$registerStatus?>">
                                <a class="nav-link" href="index.php?action=register">Register now!</a>
                            </li>';

            if (isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] === "logged_in") {
                $navElement = ' <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle <?=$myAccountStatus?>" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        My account
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="index.php?action=editAccount&user_id=' . $_SESSION['user_id'] . '">Edit profile</a>
                                        <a class="dropdown-item" href="index.php?action=resetPassword">Reset password</a>
                                    </div> 
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php?action=logout">Logout</a>
                                </li>';
            }


            $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
            $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

            unset($_SESSION['message']);
            unset($_SESSION['error']);

            require_once "app/views/" . $view . ".php";
        } else {
            echo $view;
            die('View does not exist');
        }
    }
}
