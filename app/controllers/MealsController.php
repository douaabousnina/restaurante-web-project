<?php

require_once 'app/libs/Controller.php';
require_once 'app/models/MealModel.php';

class MealsController extends Controller
{
    private static $mealModel;

    public static function getModel(): MealModel
    {
        if (is_null(static::$mealModel))
            static::$mealModel = new MealModel();
        return static::$mealModel;
    }


    //show all meals
    public static function index()
    {

        $_SESSION['navActive'] = 'meals';

        $meals = static::getModel()->showAllMeals();
        self::loadView('client/meals/meals', [
            'meals' => $meals,
            'mealsStatus' => 'active' //! à revoir
        ]);
    }

    public static function indexAdmin()
    {
        $_SESSION['navActive'] = 'meals';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['column'])) {
                $meals = self::getModel()->showAllMeals($_POST['column']);      //? Ceci est pour le tri (tri ASC selon $column)
            }
        } else
            $meals = static::getModel()->showAllMeals();  //? Par défaut tri ASC selon le ID
        self::loadView('admin/meals/meals', [
            'meals' => $meals
        ]);
    }


    //showing meal for client
    public static function show()
    {
        $_SESSION['navActive'] = 'meals';

        if (isset($_GET['meal_id'])) {
            $meal = self::getModel()->showMeal($_GET['meal_id']);
            if ($meal === true) {
                self::loadView('client/meals/meal', [
                    'meal' => $meal,
                    'mealsStatus' => 'active' //! a revoir
                ]);
                exit();
            }
        }
        header('location: index.php?action=meals');
        exit();
    }


    //showing meal for admin 
    public static function info()
    {
        $_SESSION['navActive'] = 'orders';

        if (isset($_GET['meal_id'])) {
            $meal = self::getModel()->showMeal($_GET['meal_id']);
            if ($meal === true) {
                self::loadView('admin/meals/mealInfo', [
                    'meal' => $meal
                ]);
                exit();
            }
        }
        header('location: index.php?adminAction=orders');
        exit();
    }


    // Adding a meal to the db
    public static function add()
    {
        $_SESSION['navActive'] = 'meals';

        self::loadView('admin/meals/addMeal');
    }


    public static function store()
    {


        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            extract($_POST);
            $_SESSION['error'] = [];

            //validating meal
            if (empty($meal_name)) $_SESSION['error'][] = "<div class='alert alert-danger'>Meal name is required.</div>";
            if (empty($meal_price)) $_SESSION['error'][] = "<div class='alert alert-danger'>Meal price is required.</div>";
            if (!is_numeric($meal_price) || $meal_price <= 0)  $_SESSION['error'][] = "<div class='alert alert-danger'>Invalid meal price. Please enter a positive number.</div>";

            if (empty($_SESSION['error'])) {
                static::getModel()->setMealName($meal_name)
                    ->setMealPrice($meal_price)
                    ->setMealImageUrl($meal_image_url)
                    ->addMeal();
                $_SESSION['message'] = '<div class="alert alert-success">Meal added successfully</div>';

                header('location: index.php?adminAction=meals');
                exit();
            }
        }
        header('loaction: index.php?adminAction=meals');
        exit();
    }

    // Editing meal info in the db
    public static function edit()
    {
        $_SESSION['navActive'] = 'meals';

        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['meal_id'])) {
            $meal = self::getModel()->showMeal($_GET['meal_id']);
            if ($meal == true) {
                self::loadView('admin/meals/editMeal', ['meal' => $meal]);
            }
        }
        header('loaction: index.php?adminAction=meals');
        exit();
    }


    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['meal_id'])) {
            extract($_POST);

            //validating meal info
            if (empty($meal_name)) $_SESSION['error'] .= "<div class='alert alert-danger'>Meal name is required.</div>";
            if (empty($meal_price)) $_SESSION['error'] .= "<div class='alert alert-danger'>Meal price is required.</div>";
            if (!is_numeric($meal_price) || $meal_price <= 0)  $_SESSION['error'] .= "<div class='alert alert-danger'>Invalid meal price. Please enter a positive number.</div>";

            if (!isset($_SESSION['error'])) {
                $isUpdated = static::getModel()->setMealName($meal_name)
                    ->setMealPrice($meal_price)
                    ->setMealImageUrl($meal_image_url)
                    ->updateMeal($_GET['meal_id']);

                if ($isUpdated == true)
                    $_SESSION['message'] = '<div class="alert alert-success">Meal updated successfully.</div>';

                else
                    $_SESSION['error'] = '<div class="alert alert-danger">Cannot update meal.</div>';
            }
        }
        header('location: index.php?adminAction=meals');
        exit();
    }

    //Deleting a meal from the db
    public static function delete()
    {


        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['meal_id'])) {
            $isDeleted = static::getModel()->deleteMeal($_GET['meal_id']);
            if ($isDeleted === true)
                $_SESSION['message'] = '<div class="alert alert-success">Meal deleted successfully.</div>';
            else
                $_SESSION['error'] = '<div class="alert alert-danger">Cannot delete meal.</div>';
        }

        header('location: index.php?adminAction=meals');
    }
}
