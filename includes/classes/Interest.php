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