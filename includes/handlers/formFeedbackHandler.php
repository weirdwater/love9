<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 23/08/15
 * Time: 19:14
 */

namespace toolbox;


class formFeedbackHandler
{
    private $attempt = false,
            $view;

    public function __constructor($view)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->attempt = true;
            $this->view = $view;
        }
    }
}