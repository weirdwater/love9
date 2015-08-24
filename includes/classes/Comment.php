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

    public function showComment()
    {
        global $user;

        if ($user->isLoggedIn()
            && $this->from->getId() == $user->getPerson()->getId()) {
            require TEMPLATES . 'comment-user.php';
        }
        else {
            require TEMPLATES . 'comment.php';
        }
    }
}