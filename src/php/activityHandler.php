<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/25/2018
 * Time: 4:41 PM
 */
/* include required classes */
require_once('dB.php');
require_once('user.php');
require_once('card.php');
require_once('activity.php');

$db = new dB();
$user = new user($db);
$card = new card($db);
$activity = new activity($db);

$request = $_POST['request'];

if ($request == "get")
{
    $result = $activity->getAllActivityReverse();

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

            $cardID = $row["card_cardID"];
            $cardNameResult = $card->getCardByID($cardID);
            if ($cardNameResult->num_rows > 0)
            {
                $row["card_cardID"] = $cardNameResult->fetch_assoc()['cardName'];
            }
            else {
                $row["card_cardID"] = "Unknown Card";
            }

            $dbdata[]=$row;
        }
    }
    else {
        $dbata[0] = "No activity";
    }

    echo json_encode($dbdata);
}