<?php

require_once 'app/libs/Controller.php';
require_once 'app/controllers/MealsController.php';
require_once 'app/controllers/OrdersController.php';

class HomeController extends Controller
{


    public static function index()
    {
        $_SESSION['navActive'] = 'home';

        if (isset($_SESSION['welcome_message_shown']) && $_SESSION['welcome_message_shown'] === true) {
            $welcomeMessage = isset($_SESSION['welcomeMessage']) ? $_SESSION['welcomeMessage'] : '';
            $_SESSION['welcome_message_shown'] = false; //welcome message affiché only once .
        }

        $meals = MealsController::getModel()->showAllMeals();

        self::loadView("client/home", [
            'meals' => $meals,
            'welcomeMessage' => isset($welcomeMessage) ? $welcomeMessage : '',
            'homeStatus' => 'active' //! Mal9itech 7al ekher honestly
        ]);
    }


    public static function indexAdmin()
    {
        $_SESSION['navActive'] = 'home';
        if (@$_SESSION['authorized'] !== 'yes') {
            header('location: index.php?action=home');
            exit();
        }

        $orders = OrdersController::getModel()->showAllOrders();
        self::loadView('admin/homeAdmin', ['orders' => $orders]);
    }

    public static function error()
    {
        self::loadView('error');
    }
}
