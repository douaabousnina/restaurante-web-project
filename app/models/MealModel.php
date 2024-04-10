<?php

require_once 'app/libs/DataBase.php';


class MealModel
{

    private $pdo;

    private $meal_id;
    private $meal_name;
    private $meal_price;
    private $meal_image_url;



    // Constructor :

    public function __construct()
    {
        $db = new DataBase();
        $this->pdo = $db->dataBaseConnetion();
    }


    //Setters and getters :

    public function setMealId($value)
    {
        $this->meal_id = $value;
        return $this;
    }

    public function getMealId()
    {
        return $this->meal_id;
    }

    public function setMealName($value)
    {
        $this->meal_name = $value;
        return $this;
    }

    public function getMealName()
    {
        return $this->meal_name;
    }

    public function setMealPrice($value)
    {
        $this->meal_price = $value;
        return $this;
    }

    public function getMealPrice()
    {
        return $this->meal_price;
    }

    public function setMealImageUrl($value)
    {
        $this->meal_image_url = $value;
        return $this;
    }

    public function getMealImageUrl()
    {
        return $this->meal_image_url;
    }



    // CRUD operations :

    public function showAllMeals($column='meal_name', $way='ASC')
    {
        // Validation car la fonction est public :)
        $allowedColumns = ['meal_name', 'meal_id', 'meal_price'];
        $column = in_array($column, $allowedColumns) ? $column : 'meal_name';
        $way = strtoupper($way) === 'DESC' ? 'DESC' : 'ASC';

        $sqlState = $this->pdo->prepare("SELECT * FROM meals ORDER BY $column $way;");
        $sqlState->execute();
        return $sqlState->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showMeal($meal_id)
    {
        $sqlState = $this->pdo->prepare("SELECT * FROM meals WHERE meal_id=?");
        $sqlState->execute(array($meal_id));
        return $sqlState->fetchAll(PDO::FETCH_ASSOC)[0];
    }


    public function addMeal()
    {
        $sqlState = $this->pdo->prepare("INSERT INTO meals (meal_name, meal_price, meal_image_url) VALUES (?,?,?)");
        return $sqlState->execute(array($this->meal_name, $this->meal_price,$this->meal_image_url));
    }   

    public function updateMeal($meal_id)
    {
        $sqlState = $this->pdo->prepare("UPDATE meals SET 
                                                        meal_name=?,
                                                        meal_price=?,
                                                        meal_image_url=?
                                                    WHERE meal_id=?");
        return $sqlState->execute(array($this->meal_name, $this->meal_price,$this->meal_image_url,$meal_id));
    }

    public function deleteMeal($meal_id)
    {
        $sqlState = $this->pdo->prepare("DELETE FROM meals WHERE meal_id=?");
        return $sqlState->execute(array($meal_id));
    }
}
