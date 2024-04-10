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
        $meals = static::getModel()->showAllMeals();
        self::loadView('client/meals/meals', [
            'meals' => $meals,
            'mealsStatus' => 'active' //! à revoir
        ]);
    }

    public static function indexAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['column'])) {
                $meals = self::getModel()->showAllMeals($_POST['column']);      //? Ceci est pour le tri (tri ASC selon $column)
            }
        } else
            $meals = static::getModel()->showAllMeals();  //? Par défaut tri ASC selon le ID
        self::loadView('admin/meals/meals', ['meals' => $meals]);
    }


    //show a specific meal
    public static function show()
    {
        if (isset($_GET['meal_id'])) {
            $meal = static::getModel()->showMeal($_GET['meal_id']);
            if (empty($meal)) {
                $_SESSION['error'] = 'We have no such product.';
                header('location: index.php?action=meals');
                exit();
            } 
            self::loadView('client/meals/meal', [
                'meal' => $meal,
                'mealsStatus' => 'active'
            ]);
        }
    }


    // 'la fiche technique' of the meal
    public static function info()
    {
        $meal_id = $_GET['meal_id'];
        $meal = static::getModel()->showMeal($meal_id);
        self::loadView('admin/meals/mealInfo', [
            'meal' => $meal
        ]);
    }


    public static function add()
    {
        self::loadView('admin/meals/addMeal');
    }


    public static function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            extract($_POST);
            //Verification des choses betbi3a
            static::getModel()->setMealName($meal_name)
                ->setMealPrice($meal_price)
                ->setMealImageUrl($meal_image_url)
                ->addMeal();
        }
        header('location: index.php?adminAction=meals');
    }

    public static function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['meal_id'])) {
            $meal = self::getModel()->showMeal($_GET['meal_id']);
            if ($meal) {
                self::loadView('admin/meals/editMeal', ['meal' => $meal]);
                return;
            } else {
                $_SESSION['error'] = 'Meal not found.';
            }
        }
        header('location: index.php?adminAction=orders');
    }


    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['meal_id'])) {
            extract($_POST);
            $isUpdated = static::getModel()->setMealName($meal_name)
                ->setMealPrice($meal_price)
                ->setMealImageUrl($meal_image_url)
                ->updateMeal($_GET['meal_id']);
            if ($isUpdated === true)
                $_SESSION['message'] = 'Meal updated successfully.';
            else
                $_SESSION['error'] = 'Cannot update meal.';
        }
        header('location: index.php?adminAction=meals');
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['meal_id'])) {
            $isDeleted = static::getModel()->deleteMeal($_GET['meal_id']);
            if ($isDeleted === true)
                $_SESSION['message'] = 'Meal deleted successfully.';
            else
                $_SESSION['error'] = 'Cannot delete meal.';
        }
        header('location: index.php?adminAction=meals');
    }
}
