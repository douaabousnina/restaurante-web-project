<?php

require_once 'app/libs/DataBase.php';

class OrderModel
{
    private $pdo;

    private $order_id;
    private $order_date;
    private $order_status;
    //clés étrangères:
    private $meal_id;
    private $user_id;

    // Constructor :

    public function __construct()
    {
        $db = new DataBase();
        $this->pdo = $db->dataBaseConnetion();
    }


    // Setters and getters :
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }

    public function setOrderDate($order_date)
    {
        $this->order_date = $order_date;
        return $this;
    }

    public function setOrderStatus($order_status)
    {
        $this->order_status = $order_status;
        return $this;
    }

    public function setMealId($meal_id)
    {
        $this->meal_id = $meal_id;
        return $this;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    // Getters
    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getOrderDate()
    {
        return $this->order_date;
    }

    public function getOrderStatus()
    {
        return $this->order_status;
    }

    public function getMealId()
    {
        return $this->meal_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }


    // CRUD operations :

    public function showAllOrders($column = 'order_date', $way = 'ASC')
    {
        // Validation car la fonction est public :)
        $allowedColumns = ['order_date', 'order_status', 'meal_id', 'user_id', 'order_id'];
        $column = in_array($column, $allowedColumns) ? $column : 'order_date';
        $way = strtoupper($way) === 'DESC' ? 'DESC' : 'ASC';

        $sqlState = $this->pdo->prepare("SELECT * FROM orders ORDER BY $column $way;");
        $sqlState->execute();
        return $sqlState->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showOrder($order_id)
    {
        $sqlState = $this->pdo->prepare("SELECT * FROM orders WHERE order_id=?");
        $sqlState->execute(array($order_id));
        return $sqlState->fetchAll(PDO::FETCH_ASSOC)[0];
    }


    public function addOrder()
    {
        $sqlState = $this->pdo->prepare("INSERT INTO orders (order_date, order_status, meal_id, user_id) VALUES (?,?,?,?)");
        return $sqlState->execute(array($this->order_date, $this->order_status, $this->meal_id, $this->user_id));
    }

    public function updateOrder($order_id)
    {
        $sqlState = $this->pdo->prepare("UPDATE orders SET 
                                                        order_date = ?, 
                                                        order_status =?,
                                                        meal_id = ?, 
                                                        user_id = ?
                                                    WHERE order_id=?");
        return $sqlState->execute(array($this->order_date, $this->order_status, $this->meal_id, $this->user_id, $order_id));
    }

    public function deleteOrder($order_id)
    {
        $sqlState = $this->pdo->prepare("DELETE FROM orders WHERE order_id=?");
        return $sqlState->execute(array($order_id));
    }
}
