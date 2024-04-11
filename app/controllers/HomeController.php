<?php

require_once 'app/libs/Controller.php';
require_once 'app/controllers/MealsController.php';
require_once 'app/controllers/OrdersController.php';

class HomeController extends Controller
{


    public static function index()
    {
        if (isset($_SESSION['welcome_message_shown']) && $_SESSION['welcome_message_shown'] === true) {
            $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
            $_SESSION['welcome_message_shown'] = false; //welcome message affiché only once .
        }
        $meals = MealsController::getModel()->showAllMeals();
        self::loadView("client/home", [
            'meals' => $meals,
            'message' => isset($message) ? $message : '',
            'homeStatus' => 'active'
        ]);
    }


    public static function indexAdmin()
    {

        if (@$_SESSION['authorized'] !== 'yes') {
            header('location: index.php?action=home');
            exit();
        }

        if (isset($_SESSION['welcome_message_shown']) && $_SESSION['welcome_message_shown'] === true) {
            $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
            $_SESSION['welcome_message_shown'] = false; //welcome message affiché only once .
        }
        $orders = OrdersController::getModel()->showAllOrders();
        self::loadView('admin/homeAdmin', ['orders' => $orders]);
    }

    public static function error()
    {
        self::loadView('error');
    }
}
