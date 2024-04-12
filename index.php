<?php

session_start();

require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/MealsController.php';
require_once 'app/controllers/OrdersController.php';
require_once 'app/controllers/UsersController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/CartController.php';


// ROUTING :

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'home':
            HomeController::index();
            break;


            /*********** MEALS **************/
        case 'meals':
            MealsController::index();
            break;
        case 'meal':
            MealsController::show();
            break;


            /*********** AUTH **************/

        case 'register':
            AuthController::getRegisterView();
            break;
        case 'login':
            AuthController::getLoginView();
            break;
        case 'addUser':
            AuthController::register();
            break;
        case 'verifyLogin':
            AuthController::login();
            break;
        case 'logout':
            AuthController::logout();
            break;
        // case 'resetPassword':
        //     AuthController::resetPassword();
        //     break;
        // case 'resetPasswordView':
        //     AuthController::getResetPasswordView();
        //     break;


            /*********** USERS **************/

        case 'editAccount':
            UsersController::edit();
            break;
        case 'updateAccount':
            UsersController::update();
            break;
        // case 'deleteAccount':
        //     UsersController::delete();
        //     break;


            /*********** CART **************/

        case 'cart':
            CartController::index();
            break;
        case 'addToCart':
            CartController::add();
            break;
        case 'removeFromCart':
            CartController::remove();
            break;
        case 'clearCart':
            CartController::clear();
            break;
        case 'setQuantity':
            CartController::setQuantity();
            break;


        default:
            HomeController::error();
            break;
    }
}



if (isset($_GET['adminAction'])) {
    $action = $_GET['adminAction'];
    switch ($action) {
        case 'home':
            HomeController::indexAdmin();
            break;


            /*********** MEALS **************/
        case 'meals':
            MealsController::indexAdmin();
            break;
        case 'mealInfo':
            MealsController::info();
            break;
        case 'deleteMeal':
            MealsController::delete();
            break;
        case 'addMeal':
            MealsController::add();
            break;
        case 'storeMeal':
            MealsController::store();
            break;
        case 'editMeal':
            MealsController::edit();
            break;
        case 'updateMeal':
            MealsController::update();
            break;


            /*********** USERS **************/

        case 'users':
            UsersController::indexAdmin();
            break;
        case'userProfile':
            UsersController::profile();
            break;
        case 'deleteUser':
            UsersController::delete();
            break;
        case 'editUser' :
            UsersController::edit();
            break;
        case 'updateUser':
            UsersController::update();
            break;


            /*********** ORDERS **************/
        case 'orders':
            OrdersController::indexAdmin();
            break;
        case 'editOrder':
            OrdersController::edit();
            break;
        case 'updateOrder':
            OrdersController::update();
            break;
        case 'deleteOrder':
            OrdersController::delete();
            break;



        default:
            HomeController::error();
            break;
    }
}
