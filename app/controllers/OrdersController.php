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
            if ($isUpdated === true) {
                $_SESSION['message'] = 'Order updated successfully.';
            } else {
                $_SESSION['error'] = 'Failed to update order. Please try again.';
            }
        }
        header('location: index.php?adminAction=orders');
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['order_id'])) {
            $isDeleted = static::getModel()->deleteOrder($_GET['order_id']);
            if ($isDeleted === true) {
                $_SESSION['message'] = 'Order deleted successfully.';
            } else {
                $_SESSION['error'] = 'Failed to delete order. Please try again.';
            }
        }
        header('location: index.php?adminAction=orders');
    }
}
