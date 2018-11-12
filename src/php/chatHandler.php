<?php
/**
 * Created by PhpStorm.
 * User: allen
 * Date: 11/11/2018
 */
/* include required classes */
require_once('dB.php');
require_once('user.php');
require_once('project.php');
require_once('message.php');


$db = new dB();
$user = new user($db);
//$project = new project($db);
$message = new message($db);

$request = $_POST['request'];

if ($request == "get")
{
    $result = $message->getAllMessages();

    // The array that holds the JSON data (Note: not in JSON format until encoded)
    $dbdata = array();

    if ($result->num_rows > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {
            $userID = $row["user_userID"];
            $userNameResult = $user->getUserNameByUserID($userID);
            if ($userNameResult->num_rows > 0)
            {
                $userName = $userNameResult->fetch_assoc()['userName'];
                $row["user_userID"] = $userName;

                //echo "". $row["timeSent"]. "<br/>   ". $row["user_userID"]. "<br/>   ". $row["content"]. "<br/> <br/>";
                $dbdata[]=$row;
            }
            else {
                echo 'alert("User name not found");';
                echo "<br>";
            }
        }
    }
    else {
        echo "0 results";
    }
}
elseif ($request == "send") {
        // TODO: Send Message
}
else {
    $dbdata = "Invalid request: " . $request;
}

echo json_encode($dbdata);

