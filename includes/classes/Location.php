<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 20/08/15
 * Time: 08:55
 */

namespace love9;


class Location
{
    private $city,
            $code,
            $state,
            $id;

    public function __construct($city, $code, $state, $id)
    {

        $this->city = $city;
        $this->code = $code;
        $this->state = $state;
        $this->id = $id;
    }

    public function getLocation()
    {
        return $this->city . ', ' . $this->code;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}