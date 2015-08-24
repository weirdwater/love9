<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 20/08/15
 * Time: 23:54
 */

namespace love9;


class Comment
{
    private $id,
            $from,
            $to,
            $timestamp;
    private $body;

    public function __construct($id, $from, $to, $body, $timestamp)
    {
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
        $this->body = $body;
        $this->timestamp = $timestamp;
    }

    public static function withId($id)
    {
        global $db;
        global $exceptionHandler;

        if (is_numeric($id)) {
            try {
                $comment = $db->prepare('
                    SELECT *
                    FROM Comments
                    WHERE commentId = ?
                ');
                $comment->execute([$id]);
                $comment = $comment->fetch(\PDO::FETCH_ASSOC);
                $instance = new self(
                    $comment['commentId'],
                    Person::withId($comment['fromPersonId']),
                    Person::withId($comment['toPersonId']),
                    $comment['body'],
                    $comment['timestamp']
                );
                return $instance;
            }
            catch (\Exception $e) {
                $exceptionHandler->databaseException($e, 'Comment');
                return false;
            }

        }

    }

    public function delete()
    {
        global $user;
        global $db;
        global $exceptionHandler;

        if ($user->getPerson()->getId() == $this->from->getId()
            || $user->getPerson()->getId() == $this->to->getId()) {

            $delete = $db->prepare('
                DELETE FROM Comments
                WHERE commentId = ?
            ');
            $delete->execute([$this->id]);
        }
    }

    public function showComment()
    {
        global $user;
        require TEMPLATES . 'comment.php';
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }
}