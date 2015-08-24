<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 24/08/15
 * Time: 00:56
 */

namespace toolbox;


use love9\Alert;
use love9\Person;
use love9\User;

class SignupHandler
{
    private $form1 = [
        'signup-email' => FILTER_VALIDATE_EMAIL,
        'signup-password' => FILTER_SANITIZE_STRING,
        'signup-password-check' => FILTER_SANITIZE_STRING
    ];
    private $form2 = [
        'name' => FILTER_SANITIZE_STRING,
        'surname' => FILTER_SANITIZE_STRING,
        'dob' => FILTER_SANITIZE_STRING,
        'height' => FILTER_SANITIZE_NUMBER_INT,
        'sex' => FILTER_SANITIZE_STRING,
        'prefSex' => FILTER_SANITIZE_STRING,
        'eyeColor' => FILTER_SANITIZE_NUMBER_INT,
        'hairColor' => FILTER_SANITIZE_NUMBER_INT,
        'bio' => FILTER_SANITIZE_STRING,
        'interests' => FILTER_SANITIZE_STRING,
        'dislikes' => FILTER_SANITIZE_STRING,
        'city' => FILTER_SANITIZE_STRING,
        'state' => FILTER_SANITIZE_NUMBER_INT
    ];
    private $values;
    private $alerts;


    public function __construct($form)
    {
        switch ($form) {
            case 1:
                $this->form = $this->form1;
                break;
            case 2:
                $this->form = $this->form2;
                break;
        }
    }

    public static function signup()
    {
        $instance = new SignupHandler(1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($instance->filterPost())
                if ($instance->PasswordsMatch()) {
                    global $user;
                    if ($user->recordNew($instance->getValues()))
                        header('location:'.BASE_URL.'?view=profile&action=create');
                    else {
                        global $exceptionHandler;
                        $exceptionHandler->addAlert('danger', 'Signup failed.');
                    }
                }
        }
        return $instance;
    }

    public static function profileSetup()
    {
        $instance = new SignupHandler(2);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($instance->filterPost()) {
                $person = Person::recordNew($instance->getValues());
                if ($person) {
                    global $user;
                    $user->pairPerson($person);
                    header('location:'.BASE_URL.'?view=person&id='.$person->getId());
                }
            }
        }
        return $instance;
    }

    private function filterPost()
    {
        $clean = true;
        $this->values = filter_input_array(INPUT_POST, $this->form);
        foreach ($this->values as $index => $value) {
            if (empty($value)) {
                $this->addAlert($index, 'Can\'t be left empty', 'danger');
                $clean = false;
            }
            if ($value === false) {
                $this->addAlert($index);
                $clean = false;
            }
        }
        return $clean;
    }

    private function PasswordsMatch()
    {
        if ($this->values['signup-password'] === $this->values['signup-password-check'])
            return true;
        else {
            $this->addAlert('signup-password-check');
            return false;
        }
    }

    private function addAlert($index, $altMessage = false, $altType = false)
    {
        switch ($index) {
            case 'signup-email':
                $message = 'Please enter a valid email.';
                $type = 'danger';
                break;
            case 'signup-password-check':
                $message = 'Passwords don\'t match.';
                $type = 'danger';
                break;
            default:
                $message = 'unknown index';
                $type = 'warning';
        }
        if ($altMessage) {
            $message = $altMessage;
            $type = $altType;
        }
        $this->alerts[$index] = new Alert($type, $message);
    }

    public function showAlert($index)
    {
        if (isset($this->alerts[$index]))
            $this->alerts[$index]->showAlert();
    }

    public function getValue($index)
    {
        if (isset($this->values[$index]))
            return $this->values[$index];
        else
            return false;
    }

    public function getOptions($index)
    {
        $tableStructures = [
            'EyeColors' => [
                'index' => 'eyeColorId',
                'value' => 'name'
            ],
            'HairColors' => [
                'index' => 'hairColorId',
                'value' => 'name'
            ],
            'States' => [
                'index' => 'stateId',
                'value' => 'code',
                'group' => [
                    'index'  => 'inUS',
                    'value' => 'US'
                ]
            ]
        ];

        switch ($index) {
            case 'eyeColor':
                $table = 'EyeColors';
                break;
            case 'hairColor':
                $table = 'HairColors';
                break;
            case 'state':
                $table = 'States';
                break;
            default:
                return 'Invalid Index';
        }

        try {
            global $db;
            $options = $db->prepare("
                SELECT *
                FROM $table
            ");
            $options->bindParam(1, $table, \PDO::PARAM_STR);
            $options->execute();
            $options = $options->fetchAll(\PDO::FETCH_ASSOC);

            $dbId = $tableStructures[$table]['index'];
            $value = $tableStructures[$table]['value'];
            $returnValue = '';
            if (isset($tableStructures[$table]['group'])) {
                $group = $tableStructures[$table]['group'];
                $returnGroup = '<optgroup label="'.$group['value'].'">\n';
            }
            foreach ($options as $option) {
                $htmlOption = "<option value=\"$option[$dbId]\" ";
                $htmlOption .= " >$option[$value]</option>\n";
                if (isset($group) && $option[$group['index']])
                    $returnGroup .= $htmlOption;
                else
                    $returnValue .= $htmlOption;
            }
            if (isset($returnGroup)) {
                $returnGroup .= '</optgroup>';
                return $returnGroup . $returnValue;
            }
            return $returnValue;
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'Options');
        }
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }
}