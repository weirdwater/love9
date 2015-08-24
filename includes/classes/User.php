<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 23/08/15
 * Time: 15:36
 */

namespace love9;


class User
{
    private $userId,
            $email,
            $verified,
            $loggedIn = false,
            $person;

    public function __constructor()
    {
        $this->person = new Person();
    }

    public static function withEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!empty($id)) {
            $instance = new User();
            $instance->retrieveInfoWithEmail($email);
            return $instance;
        }
    }

    public static function withLogin()
    {
        $email = filter_input(INPUT_POST, 'login-email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'login-password',
            FILTER_SANITIZE_STRING);

        if (!empty($email)
            && !empty($password)
            && User::correctCredentials($email, $password)) {
            $instance = new User();
            $instance->retrieveInfoWithEmail($email);
            $instance->setSession();
            header('location:' . BASE_URL);
            echo 'logged in, redirecting';
            exit;
        }
        else
            return new User();
    }

    public static function withId($id)
    {
        if (is_numeric($id) && !empty($id)) {
            $instance = new User();
            $instance->retrieveInfo($id);
            $instance->setLoggedIn();
            return $instance;
        }
    }

    public static function correctCredentials($email, $password)
    {
        try {
            global $db;
            $hash = $db->prepare('
                SELECT u.password
                FROM Users u
                WHERE u.email = ?
            ');
            $hash->bindParam(1, $email, \PDO::PARAM_STR);
            $hash->execute();
            $hash = $hash->fetch(\PDO::FETCH_ASSOC)['password'];

            if (password_verify($password, $hash))
                return true;
            else
                false;
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'Password Check');
        }
    }

    public function recordNew($values)
    {
        $email = $values['signup-email'];
        $password = $values['signup-password'];
        $password = password_hash($password, PASSWORD_DEFAULT);

        try {
            global $db;
            $insert = $db->prepare('
                INSERT INTO Users (email, `password`)
                VALUES (?, ?)
            ');
            $insert->bindParam(1, $email, \PDO::PARAM_STR);
            $insert->bindParam(2, $password, \PDO::PARAM_STR);
            $insert->execute();

            $this->userId = $db->lastInsertId();
            $_SESSION['userId'] = $this->userId;
            if ($this->userId)
                return true;
            else
                return false;
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'User::recordNew');
            return false;
        }

    }

    private function setLoggedIn()
    {
        $this->loggedIn = true;
    }

    /**
     * Starts a new session for the user
     */
    private function setSession()
    {
        $_SESSION['userId'] = $this->userId;
        $_SESSION['userPersonId'] = $this->person->getId();
    }

    private function retrieveInfo($id)
    {
        try {
            global $db;
            $info = $db->prepare('
                SELECT userId, email, verified, People_personId
                FROM Users
                WHERE userId = ?
            ');
            $info->bindParam(1, $id, \PDO::PARAM_INT);
            $info->execute();
            $info = $info->fetch(\PDO::FETCH_ASSOC);

            $this->fillProperties($info);
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'User');
        }
    }

    private function retrieveInfoWithEmail($email)
    {
        try {
            global $db;
            $info = $db->prepare('
                SELECT userId, email, verified, People_personId
                FROM Users
                WHERE email = ?
            ');
            $info->bindParam(1, $email, \PDO::PARAM_INT);
            $info->execute();
            $info = $info->fetch(\PDO::FETCH_ASSOC);

            $this->fillProperties($info);
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'User::retrieveWithEmail');
        }
    }

    public function pairPerson($person) {
        $this->person = $person;

        try {
            global $db;
            $update = $db->prepare('
                UPDATE Users
                SET People_personId=?
                WHERE userId = ?
            ');
            $update->bindValue(1, $this->person->getId(), \PDO::PARAM_INT);
            $update->bindParam(2, $this->userId, \PDO::PARAM_INT);
            $update->execute();
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'User::pairPerson');
        }
    }

    private function fillProperties($info)
    {
        $this->userId   = $info['userId'];
        $this->verified = $info['verified'];
        $this->email    = $info['email'];
        if ($info['People_personId'])
            $this->person = Person::withId($info['People_personId']);
        else
            $this->person = new Person();
    }

    public function logout()
    {
        if (session_destroy()) {
            header('location: ' . BASE_URL);
            echo 'logging you out...';
            exit;
        }
    }

    /**
     * @return mixed
     */
    public function getPerson()
    {
        return $this->person;
    }

    public function isLoggedIn()
    {
        return $this->loggedIn;
    }

    public function hasPerson()
    {
        return !!$this->person->getId();
    }
}