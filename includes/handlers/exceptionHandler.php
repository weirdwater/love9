<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 20/08/15
 * Time: 07:13
 */

namespace toolbox;


use love9\Alert;

class ExceptionHandler
{
    private $inDevelopment;
    private $alerts = [];

    /**
     * @param $inDevelopment BOOL State of project
     */
    public function __construct($inDevelopment)
    {
        $this->inDevelopment = $inDevelopment;
    }

    /**
     * @param \Exception $e Thrown exception
     * @param string $name Optional identifier.
     */
    public function databaseException($e, $name = '')
    {
        if ($this->inDevelopment) {
            echo $name . ' Exception: ' . $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine();
            exit;
        }
        else {
            echo 'An error occured while retrieving data from the database.';
            exit;
        }
    }

    public function addAlert($type, $message)
    {
        array_push($this->alerts, new Alert($type, $message));
    }

    /**
     * @return array
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    public function showAlerts()
    {
        foreach ($this->alerts as $alert) {
            $alert->showAlert();
        }
    }
}