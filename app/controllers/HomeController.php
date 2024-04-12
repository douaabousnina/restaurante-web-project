<?php

require_once 'app/libs/Controller.php';
require_once 'app/controllers/MealsController.php';
require_once 'app/controllers/OrdersController.php';

class HomeController extends Controller
{


    public static function index()
    {
        $_SESSION['navActive'] = 'home';

        $welcomeMessage= isset($_SESSION['welcomeMessage'])?  $_SESSION['welcomeMessage'] : '';
        unset($_SESSION['welcomeMessage']);


        $meals = MealsController::getModel()->showAllMeals();

        self::loadView("client/home", [
            'meals' => $meals,
            'welcomeMessage' => $welcomeMessage,
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
        if(@$_SESSION['authorized']==='yes') {
            self::loadView('admin/error');
        }
        self::loadView('client/error');
    }
}
