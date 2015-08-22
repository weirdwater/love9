<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 22/08/15
 * Time: 14:26
 */

namespace love9;


class Alert
{
    private $type,
            $message;

    public function __construct($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function showAlert()
    {
        require TEMPLATES . 'alert.php';
    }
}
