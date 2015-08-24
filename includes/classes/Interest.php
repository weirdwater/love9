<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 21/08/15
 * Time: 02:57
 */

namespace love9;


class Interest
{
    private $id,
            $name,
            $likes;

    public function __construct($id, $name, $likes)
    {
        $this->id = $id;
        $this->name = $name;
        $this->likes = $likes;
    }

    public static function fromName($name, $likes = true)
    {
        // TODO: Check with database for actual ID
        // TODO: Else create new interest
        $id = Interest::existsInDb($name);
        if (!$id) {
            $id = Interest::recordNew($name);
            if (!$id) {
                return false;
            }
        }
        $instance = new Interest($id, $name, $likes);
        return $instance;
    }

    public static function recordNew($name)
    {
        try {
            global $db;
            $interest = $db->prepare('
                INSERT INTO Interests (name)
                VALUES (?)
            ');
            $interest->bindParam(1, $name, \PDO::PARAM_STR);
            $interest->execute();
            return $db->lastInsertId();
        } catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'New Interest');
        }
        return false;
    }

    public static function existsInDb($name)
    {
        try {
            global $db;
            $interest = $db->prepare('
                SELECT *
                FROM Interests
                WHERE `name` = ?
            ');
            $interest->bindParam(1, $name, \PDO::PARAM_STR);
            $interest->execute();
            $interest = $interest->fetch(\PDO::FETCH_ASSOC);
            return $interest['interestId'];
        } catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'Interest Check');
        }
        return false;
    }

    public function showDefaultInterest()
    {
        require TEMPLATES . 'interest.php';
    }

    public function showCommonInterest()
    {
        require TEMPLATES . 'interest-common.php';
    }

    public function showConflictingInterest()
    {
        require TEMPLATES . 'interest-conflict.php';
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }
}