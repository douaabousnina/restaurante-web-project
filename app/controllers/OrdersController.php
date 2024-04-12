<?php

require_once 'app/libs/Controller.php';
require_once 'app/models/OrderModel.php';

class OrdersController extends Controller
{
    private static $orderModel;


    public static function getModel(): OrderModel
    {
        if (is_null(self::$orderModel))
            self::$orderModel = new OrderModel();
        return self::$orderModel;
    }

    public static function indexAdmin()
    {
        $_SESSION['navActive'] = 'orders';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['column'])) {
                $orders = self::getModel()->showAllOrders($_POST['column']);
            }
        } else
            $orders = self::getModel()->showAllOrders();
        static::loadView('admin/orders/orders', [
            'orders' => $orders
        ]);
    }

    public static function edit()
    {
        $_SESSION['navActive'] = 'orders';

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['order_id'])) {
            $order = self::getModel()->showOrder($_GET['order_id']);
            self::loadView('admin/orders/editOrder', [
                'order' => $order
            ]);
            exit();
        }
        header('location: index.php?adminAction=orders');
    }

    public static function update()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['order_id'])) {
            extract($_POST);
            $isUpdated = static::getModel()->setMealId($meal_id)
                ->setOrderDate($order_date)
                ->setOrderStatus($order_status)
                ->setUserId($user_id)
                ->updateOrder($_GET['order_id']);
            if ($isUpdated === true)
                $_SESSION['message'] = "<div class='alert alert-danger'>Order info updated successfully.</div>";
            else
                $_SESSION['error'] .= '<div class="alert alert-danger">Cannot update order.</div>';
        }
        header('location: index.php?adminAction=orders');
    }

    public static function delete()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['order_id'])) {
            $isDeleted = static::getModel()->deleteOrder($_GET['order_id']);
            if ($isDeleted === true)
                    $_SESSION['message'] = "<div class='alert alert-danger'>Order deleted successfully.</div>";
                else
                    $_SESSION['error'] .= '<div class="alert alert-danger">Cannot delete order.</div>';
        }
        header('location: index.php?adminAction=orders');
    }
}
