<?php

require_once 'app/libs/Controller.php';

//im storing its info fl session variables

class CartController extends Controller
{



    public static function index()
    {
        $_SESSION['navActive'] = 'cart';

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $cartItems = $_SESSION['cart'];
        $_SESSION['cartMessage'] = count($cartItems) === 0 ? '<div class="alert alert-dark">Your cart is empty.</div>' : '';

        self::loadView('client/cart/cart', [
            'cartItems' => $_SESSION['cart'],
            'cartMessage' =>$_SESSION['cartMessage'],
            'total' => self::calculateTotal(),
            'navElement' => '',
            'cartStatus' => 'active'  //! à revoir 
        ]);
    }

    public static function add()
    {
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_GET['meal_id']) && isset($_POST['quantity'])) {
                $meal_id = $_GET['meal_id'];
                $quantity = $_POST['quantity'];

                if(count(MealsController::getModel()->showMeal($meal_id))===0 || $quantity<=0) {
                    $_SESSION['error']='<div class="alert alert-danger">No product / no quantity to add to cart</div>';
                    header('location: index.php?action=home');
                    exit();
                }

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                $existingMealKey = self::findMealInCart($meal_id);
                if ($existingMealKey !== -1) {
                    $_SESSION['cart'][$existingMealKey]['quantity'] += $quantity;
                } else {
                    $meal = MealsController::getModel()->showMeal($meal_id);
                    $cartItem = [
                        'meal' => $meal,
                        'quantity' => $quantity
                    ];
                    $_SESSION['cart'][] = $cartItem;
                }
            } else {
                $_SESSION['error'] = '<div class="alert alert-danger">No product / no quantity to add to cart</div>';
            }
        }
        if (isset($_SERVER['HTTP_REFERER']))
            header("location: " . $_SERVER['HTTP_REFERER']);   //? khatar manaarach ken fl home wala fl meals 
        else
            header('location: index.php?action=meals');
        
        
        //! Un problème : manaarach kifeh nkhallih fi nafs l blassa li ken fiha, khatar it rerenders malheureusement
    }


    public static function remove()
    {
        

        if (isset($_GET['meal_id'])) {
            $meal_id = $_GET['meal_id'];
            if ($meal_id > 0) {
                $index = self::findMealInCart($meal_id);
                if ($index != -1) {
                    unset($_SESSION['cart'][$index]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                    $_SESSION['message'] = '<div class="alert alert-danger">Meal removed from cart 🔴</div>';  
                }
            }
        }
        header('location: index.php?action=cart');
    }


    public static function clear()
    {
        

        $_SESSION['cart'] = [];
        $_SESSION['message'] = '<div class="alert alert-success">Cart cleared ✅</div>';
        header('location: index.php?action=cart');
    }


    public static function calculateTotal(): string
    {
        

        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $meal = $cartItem['meal'];
                $price = $meal['meal_price'];
                $quantity = $cartItem['quantity'];
                $total += $price * $quantity;
            }
        }
        return number_format($total, 3, '.', '');
    }


    /**
     * @param int $meal_id
     */
    public static function findMealInCart($meal_id): int
    {
        

        if (isset($_SESSION['cart'])) {
            $index = -1;
            foreach ($_SESSION['cart'] as $item) {
                $index++;
                if ($item['meal']['meal_id'] == $meal_id) {
                    return $index;
                }
            }
        }
        return -1;
    }


    public static function setQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_GET['meal_id']) && isset($_POST['quantity'])) {
                $meal_id = $_GET['meal_id'];
                $quantity = intval($_POST['quantity']);
                $mealIndex = self::findMealInCart($meal_id);
    
                if (isset($_SESSION['cart']) && $mealIndex != -1) {
                    $_SESSION['cart'][$mealIndex]['quantity'] = intval($quantity);
                }
            }
        }
        header('location: index.php?action=cart');
    }
}
