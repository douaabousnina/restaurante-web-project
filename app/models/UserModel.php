<?php

require_once 'app/libs/DataBase.php';

class UserModel
{
    private $pdo;

    private $user_id;
    private $user_email;
    private $user_surname;
    private $user_age;
    private $user_login;
    private $user_password;
    private $user_role;


    // Constructor :

    public function __construct()
    {
        $db = new DataBase();
        $this->pdo = $db->dataBaseConnetion();
    }


    // Setters and getters :

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function setUserEmail($user_email)
    {
        $this->user_email = $user_email;
        return $this;
    }

    public function setUserSurname($user_surname)
    {
        $this->user_surname = $user_surname;
        return $this;
    }

    public function setUserAge($user_age)
    {
        $this->user_age = $user_age;
        return $this;
    }

    public function setUserLogin($user_login)
    {
        $this->user_login = $user_login;
        return $this;
    }

    public function setUserPassword($user_password)
    {
        $this->user_password = $user_password;
        return $this;
    }

    public function setUserRole($user_role)
    {
        $this->user_role = $user_role;
        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUserEmail()
    {
        return $this->user_email;
    }

    public function getUserSurname()
    {
        return $this->user_surname;
    }

    public function getUserAge()
    {
        return $this->user_age;
    }

    public function getUserLogin()
    {
        return $this->user_login;
    }

    public function getUserPassword()
    {
        return $this->user_password;
    }

    public function getUserRole()
    {
        return $this->user_role;
    }


    // CRUD operations :

    /**
     * @param string $column, $way
     */
    public function showAllUsers($column='', $way='')
    {
        // Validation car la fonction est public :)
        $allowedColumns = ['user_id','user_email', 'user_surname', 'user_age', 'user_login', 'user_role'];
        $column = in_array($column, $allowedColumns) ? $column : 'user_id';
        $way = strtoupper($way) === 'DESC' ? 'DESC' : 'ASC';

        $sqlState = $this->pdo->prepare("SELECT * FROM users ORDER BY $column $way");
        $sqlState->execute();
        return $sqlState->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showUser($user_id): array
    {
        return $this->where('user_id', $user_id)[0];
    }


    public function addUser(): bool
    {
        $sqlState = $this->pdo->prepare("INSERT INTO users (user_email, user_surname, user_age, user_login, user_password, user_role) VALUES (?,?,?,?,?,?)");
        return $sqlState->execute(array($this->user_email, $this->user_surname, $this->user_age, $this->user_login, password_hash($this->user_password, PASSWORD_DEFAULT), $this->user_role));
    }


    /**
     * @param int $user_id
     */
    public function updateUser($user_id): bool
    {
        $sqlState = $this->pdo->prepare("UPDATE users SET 
                                                        user_email=?,
                                                        user_surname=?,
                                                        user_age=?,
                                                        user_login=?,     
                                                        user_role=?
                                                    WHERE user_id=?");
        return $sqlState->execute(array($this->user_email, $this->user_surname, $this->user_age, $this->user_login, $this->user_role, $user_id));
    }


    /**
     * @param int $user_id
     */
    public function changePassword($user_id) {
        $sqlState = $this->pdo->prepare("UPDATE users SET user_password=? WHERE user_id=?");
        return $sqlState->execute(array(password_hash($this->user_password, PASSWORD_DEFAULT), $user_id));
    }


    /**
     * @param int $user_id
     */
    public function deleteUser($user_id): bool
    {
        $sqlState = $this->pdo->prepare("DELETE FROM users WHERE user_id=?");
        return $sqlState->execute(array($user_id));
    }


    /**
     * @param string $column
     * @param string|int $value
     * @param string $operator
     */
    public function where($column, $value, $operator = '='): array
    {
        $sqlState = $this->pdo->prepare("SELECT * FROM users WHERE $column $operator ?");
        $sqlState->execute(array($value));
        return $sqlState->fetchAll(PDO::FETCH_ASSOC);
    }
}
