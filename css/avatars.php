<?php
/*
 * avatars.php
 * Returns css that tells the browser where the desired avatars are.
 * Get the desired css by adding the user ids, seperated by commas, to the get
 * variable users.
 * Example: avatars.php?users=1,2,3
 */

/*
 * Sets the header's content type to text/css so the browser will recognize it
 * as a stylesheet.
 */
header("Content-type: text/css");

/*
 * To avoid php error messages we first check to see if the get variable
 * 'users' has been set, and filled.
 */
if (isset($_GET['users']) && !empty($_GET['users']))
{
    /*
     * In order to send multiple ids at once we imploded the array of user ids
     * earlier. This is preferred to having separate get variables for each
     * respective user id.
     */
    $implodedUsers = $_GET['users'];
    $users = explode(",", $implodedUsers);

    /*
     * For each user we load the avatar-template.php css template file. It
     * includes all the required css with a few echo statements throughout.
     * This is done so the content is separate from the php logic. If we need
     * to change the css we can do so in the template file without having to
     * search for it in this file.
     * It also keeps this file cleaner. Which keeps it readable.
     */
    foreach ($users as $user => $id)
    {
        require "avatar-template.php";
    }
}