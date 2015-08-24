<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 20/08/15
 * Time: 23:33
 */

namespace love9;


class Profile
{
    private $person,
            $comments = [],
            $rating;

    public function __construct($person)
    {
        $this->person = $person;
        $this->newCommentHandler();
        $this->retrieveComments();
        $this->retrieveRatings();
    }

    public function showProfile()
    {
        global $exceptionHandler;
        global $user;
        require TEMPLATES . 'profile.php';
    }

    private function retrieveComments()
    {
        // TODO: Retrieve list of comments + personIds & names
        try {
            global $db;
            $comments = $db->prepare('
                SELECT c.body, c.fromPersonId, c.timestamp, c.commentId
                FROM Comments c
                WHERE toPersonId = ?
                ORDER BY c.timestamp ASC
            ');
            $comments->bindValue(1, $this->person->getId());
            $comments->execute();
            $comments = $comments->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($comments as $comment) {
                $newComment = new Comment(
                    $comment['commentId'],
                    Person::withId($comment['fromPersonId']),
                    $this->person,
                    $comment['body'],
                    $comment['timestamp']
                );
                array_push($this->comments, $newComment);
            }

        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e);
        }
    }

    private function newCommentHandler() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'
            && isset($_POST['comment-body'])
            && !empty($_POST['comment-body'])) {
            $body = filter_input(INPUT_POST, 'comment-body', FILTER_SANITIZE_STRING);
            try {
                global $db;
                global $user;
                $insert = $db->prepare('
                     INSERT INTO Comments (body, fromPersonId, toPersonId)
                     VALUES (?, ?, ?)
                ');
                $insert->bindParam(1, $body, \PDO::PARAM_STR);
                $insert->bindValue(2, $user->getPerson()->getId(), \PDO::PARAM_STR);
                $insert->bindValue(3, $this->person->getId(), \PDO::PARAM_STR);
                $insert->execute();
            }
            catch (\Exception $e) {
                global $exceptionHandler;
                $exceptionHandler->databaseException($e, 'Interests');
            }
        }
    }

    private function retrieveRatings()
    {
        // TODO: Retrieve rating data
    }
}