<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 20/08/15
 * Time: 06:47
 */

namespace love9;


class Person
{
    private $name,
            $surname,
            $dob,
            $height,
            $sex,
            $preferredSex,
            $eyeColor,
            $hairColor,
            $interests = [],
            $bio,
            $avatar,
            $id,
            $inUserFavorites;
    public  $location;

    public function __construct($name = null, $surname = null, $dob = null,
                                $height = null, $sex = null,
                                $preferredSex = null, $location = null,
                                $bio = null, $avatar = null, $id = null)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->dob = $dob;
        $this->sex = $sex;
        $this->preferredSex = $preferredSex;
        $this->location = $location;
        $this->bio = $bio;
        $this->avatar = $avatar;
        $this->id = $id;
        $this->height = $height;
    }

    /**
     * Retrieves user info from the database, and adds it to the
     * @param INT $id Corresponding personId from the database
     */
    public function retreiveInfo($id)
    {
        try {
            global $db;
            $personInfo = $db->prepare('
                SELECT personId, p.name, surname, dob, sex, preferredSex, bio,
                city, p.stateId, s.name AS state, s.code, p.hairColorId,
                hc.name AS hairColor, p.eyeColorId, ec.name AS eyeColor,
                p.height
                FROM People p, States s, EyeColors ec, HairColors hc
                WHERE personId = ?
                AND p.stateId = s.stateId
                AND p.eyeColorId = ec.eyeColorId
                AND p.hairColorId = hc.hairColorId;
            ');
            $personInfo->bindParam(1, $id, \PDO::PARAM_INT);
            $personInfo->execute();
            $personInfo = $personInfo->fetch(\PDO::FETCH_ASSOC);

            // Set all info to the user object.
            $this->name = $personInfo['name'];
            $this->surname = $personInfo['surname'];
            $this->dob = $personInfo['dob'];
            $this->sex = $personInfo['sex'];
            $this->preferredSex = $personInfo['preferredSex'];
            $this->location = new Location(
                $personInfo['city'],
                $personInfo['code'],
                $personInfo['state'],
                $personInfo['stateId']
            );
            $this->bio = $personInfo['bio'];
            $this->avatar = 'avatar_'. $personInfo['personId'] .'.png';
            $this->id = $personInfo['personId'];
            $this->height = $personInfo['height'];
            $this->eyeColor = $personInfo['eyeColor'];
            $this->hairColor = $personInfo['hairColor'];

            global $requiredAvatars;
            array_push($requiredAvatars, $id);

        } catch (\PDOException $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'Person info');
        }
    }

    private function retrieveFavoriteStatus()
    {
        try {
            global $db;
            $status = $db->prepare('
                SELECT COUNT(*) as numberOf
                FROM Favorites
                WHERE personId = ?
                AND favoritedPersonId = ?
            ');
            $status->bindParam(1, $_SESSION['userPersonId'], \PDO::PARAM_INT);
            $status->bindParam(2, $this->id, \PDO::PARAM_INT);
            $status->execute();
            $status = $status->fetch(\PDO::FETCH_ASSOC)['numberOf'];

            /*
             * Sets the variable to true or false, according to the number of
             * records found in the database.
             */
            $this->inUserFavorites = !!$status;
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'Favourites Status');
        }
    }

    public function retrieveInterests()
    {
        try {
            global $db;
            $interests = $db->prepare('
                SELECT  *
                FROM Interests i, Interests_has_People ir
                WHERE i.interestId = ir.Interests_interestId
                AND ir.People_personId = ?
            ');
            $interests->bindParam(1, $this->id, \PDO::PARAM_INT);
            $interests->execute();
            $interests = $interests->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($interests as $interest)
                array_push($this->interests, new Interest(
                    $interest['interestId'],
                    $interest['name'],
                    $interest['likes']
                ));
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'Interests');
        }
    }

    public function addToFavorites()
    {
        global $db;
        global $user;
        global $exceptionHandler;
        try {
            $add = $db->prepare('
                INSERT INTO Favorites (personId, favoritedPersonId)
                VALUES (?, ?)
            ');
            $add->bindValue(1, $user->getPerson()->getId());
            $add->bindParam(2, $this->id, \PDO::PARAM_INT);
            $add->execute();
        }
        catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                $exceptionHandler->addAlert('warning', $this->getName()
                    . ' already is in your favorites.');
            }
            else {
                $exceptionHandler->databaseException($e, 'Favorites Add');
            }
            return false;
        }
        $this->inUserFavorites = true;
        $exceptionHandler->addAlert('success', $this->getName()
            . ' was added to your favorites.');
    }

    public function deleteUser()
    {
        global $db,
               $user,
               $exceptionHandler;
        try {

            $sql = [
                // Remove personIDfrom user
                'UPDATE users SET People_personId=NULL WHERE People_personId = :personId',
                // Delete interests
                'DELETE FROM People WHERE personId = :personId'

            ];
            foreach ($sql as $sqlStatement) {
                $statement = $db->prepare($sqlStatement);
                $statement->bindParam(':personId', $this->id, \PDO::PARAM_INT);
                $statement->execute();
                $statement->closeCursor();
            }
            $exceptionHandler->addAlert('info', 'Profile deleted.');

        }
        catch (\Exception $e) {
            $exceptionHandler->databaseException($e, 'Person Delete');
            return false;
        }
    }

    public function removeFromFavorites()
    {
        global $db;
        global $user;
        global $exceptionHandler;
        try {
            $add = $db->prepare('
                    DELETE FROM Favorites
                    WHERE personId = ?
                    AND favoritedPersonId = ?
            ');
            $add->bindValue(1, $user->getPerson()->getId());
            $add->bindParam(2, $this->id, \PDO::PARAM_INT);
            $add->execute();
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'Favorites Add');
            return false;
        }
        $this->inUserFavorites = false;
        $exceptionHandler->addAlert('success', $this->getName()
            . ' was removed from your favorites.');
    }

    public static function withId($id)
    {
        if (is_numeric($id))
        {
            $instance = new self();
            $instance->retreiveInfo($id);
            $instance->retrieveInterests();
            $instance->retrieveFavoriteStatus();
            return $instance;
        }
    }

    public static function recordNew($values)
    {
        $newPerson = new Person(
            $values['name'],
            $values['surname'],
            $values['dob'],
            $values['height'],
            $values['sex'],
            $values['prefSex'],
            new Location($values['city'], null, null, $values['state']),
            $values['bio']
        );
        $newPerson->setHairColor($values['hairColor']);
        $newPerson->seteyeColor($values['eyeColor']);
        $newPerson->addInterestsFromString($values['interests'], true);
        $newPerson->addInterestsFromString($values['dislikes'], false);
        if (!$newPerson->recordNewToDB())
            return false;
        else {
            $newPerson->saveInterests();
            return $newPerson;
        }
    }

    public function recordNewToDB()
    {
        global $db;
        global $exceptionHandler;
        try {

            $insert = $db->prepare('
                INSERT INTO People (`name`, surname, dob, sex, preferredSex, bio, city, stateId, eyeColorId, hairColorId, height)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');
            $insert->bindParam(1, $this->name, \PDO::PARAM_STR);
            $insert->bindParam(2, $this->surname, \PDO::PARAM_STR);
            $insert->bindParam(3, $this->dob, \PDO::PARAM_STR);
            $insert->bindParam(4, $this->sex, \PDO::PARAM_STR);
            $insert->bindParam(5, $this->preferredSex, \PDO::PARAM_STR);
            $insert->bindParam(6, $this->bio, \PDO::PARAM_STR);
            $insert->bindValue(7, $this->location->getCity(), \PDO::PARAM_STR);
            $insert->bindValue(8, $this->location->getId(), \PDO::PARAM_INT);
            $insert->bindParam(9, $this->eyeColor, \PDO::PARAM_INT);
            $insert->bindParam(10, $this->hairColor, \PDO::PARAM_INT);
            $insert->bindParam(11, $this->height, \PDO::PARAM_INT);
            $insert->execute();
            $this->id = $db->lastInsertId();
            if (!$this->id) {
                $exceptionHandler->addAlert('danger', 'Unsuccessful insert.');
                return false;
            }
            else
                return true;
        }
        catch (\Exception $e) {
            $exceptionHandler->databaseException($e, 'Favorites Add');
            return false;
        }
    }

    public function saveInterests() {
        global $db;
        try {
            // Delete all interests of the user
            $clear = $db->prepare('
                DELETE FROM Interests_has_People
                WHERE People_personId = ?
            ');
            $clear->bindParam(1, $this->id, \PDO::PARAM_INT);
            $clear->execute();

            // Add current interests
            $insert = $db->prepare('
                INSERT INTO Interests_has_People (Interests_interestId, People_personId, likes)
                VALUES (?, ?, ?)
            ');
            foreach ($this->interests as $interest) {
                $params = [$interest->getId(), $this->id, $interest->getLikes()];
                $insert->execute($params);
            }
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'Favorites Add');
            return false;
        }
    }

    private function addInterestsFromString($string, $likes)
    {
        $interests = explode(', ', $string);
        foreach ($interests as $interest) {
            array_push($this->interests, Interest::fromName($interest, $likes));
        }
    }

    public function dislikesInterest($interestId)
    {
        foreach ($this->interests as $interest) {
            if ($interest->getId() == $interestId
                && $interest->getLikes() == 0)
                return true;
        }
        return false;
    }

    public function likesInterest($interestId)
    {
        foreach ($this->interests as $interest) {
            if ($interest->getId() == $interestId
                && $interest->getLikes() == 1)
                return true;
        }
        return false;
    }

    public function dumpAllVariables()
    {
        echo '<pre>';
        var_dump($this);
        exit;
    }

    public function showPeopleGridItem()
    {
        require TEMPLATES . 'people-grid-item.php';
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
 * @return null
 */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return null
     */
    public function getFullName()
    {
        return $this->name .' '. $this->surname;
    }

    /**
     * @return null
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @return null
     */
    public function getSex()
    {
        return $this->sex;
    }

    public function getAge()
    {
        $birthday = new \DateTime($this->dob);
        $now = new \DateTime('NOW');
        $interval = $birthday->diff($now);
        return strftime($interval->format('%Y'));
    }

    /**
     * @return null
     */
    public function getPreferredSex()
    {
        return $this->preferredSex;
    }

    /**
     * @return null
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return array|null
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * @return null
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @return null
     */
    public function getAvatar()
    {
        return BASE_URL . 'img/avatar/avatar_'.$this->id.'.png';
    }

    /**
     * @return null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return null
     */
    public function getHeightInCm()
    {
        return $this->height . 'cm';
    }

    /**
     * @return mixed
     */
    public function getEyeColor()
    {
        return $this->eyeColor;
    }

    /**
     * @return mixed
     */
    public function getHairColor()
    {
        return $this->hairColor;
    }

    /**
     * @return mixed
     */
    public function isInUserFavorites()
    {
        return $this->inUserFavorites;
    }

    /**
     * @param mixed $eyeColor
     */
    public function setEyeColor($eyeColor)
    {
        $this->eyeColor = $eyeColor;
    }

    /**
     * @param mixed $hairColor
     */
    public function setHairColor($hairColor)
    {
        $this->hairColor = $hairColor;
    }
}