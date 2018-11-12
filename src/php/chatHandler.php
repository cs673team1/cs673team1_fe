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
                $row["user_userID"] = $userNameResult->fetch_assoc()['userName'];
            }
            else {
                $row["user_userID"] = "Unknown User";
            }

            $dbdata[]=$row;
        }
    }
    else {
        $dbata[0] = "No messages";
    }

    echo json_encode($dbdata);
}
elseif ($request == "send") {
    $userName = "Allen Bouchard"; //$_POST["user"];
    $content = "Yet another test message"; //$_POST["content"];
    $projectName = "The Project";

    $result = $project->getProjectIdByName($projectName);
    $result2 = $user->getUserIdByUserName($userName);
    if ($result->num_rows > 0 AND $result2->num_rows > 0) {
        $projectID = $result->fetch_assoc()['projectID'];
        $userID = $result2->fetch_assoc()['userID'];
        $result = $message->addMessage($content, $projectID, $userID);
    }
}

$db->closeDB();