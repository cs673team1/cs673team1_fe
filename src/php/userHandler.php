<?php
/**
 * Created by PhpStorm.
 * User: allen
 * Date: 11/12/2018
 * Time: 12:00 PM
 */

require_once('dB.php');
require_once('user.php');
require_once('project.php');

$db = new dB();
$user = new user($db);
//$project = new project($db);

$request = $_POST['request'];

if ($request == "get")
{
    $result = $user->getAllUsers();

    // The array that holds the JSON data (Note: not in JSON format until encoded)
    $dbdata = array();

    if ($result->num_rows > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {
            $dbdata[]=$row;
        }
    }
    else {
        $dbdata[0] = "Error: No users";
    }
}
else {
    $dbdata[0] = "Invalid request: " . $request;
}

echo json_encode($dbdata);

