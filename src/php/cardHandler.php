<?php
/**
 * Created by PhpStorm.
 * User: allen
 * Date: 11/13/2018
 * Time: 4:26 PM
 */
/* include required classes */
require_once('dB.php');
require_once('user.php');
require_once('project.php');
require_once('card.php');
require_once ('status.php');
require_once ('cardType.php');


$db = new dB();
$user = new user($db);
$project = new project($db);
$card = new card($db);
$status = new status($db);
$cardType = new cardType($db);


//$request = $_POST['request'];
$request = "get";

if ($request == "get")
{
    $result = $card->getAllCards();

    // The array that holds the JSON data (Note: not in JSON format until encoded)
    $dbdata = array();

    if ($result->num_rows > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {
            /*$statusID = $row["status"];
            $statusResult = $status->getStatusByID($statusID);
            if ($statusResult->num_rows > 0)
            {
                $row["status"] = $statusResult->fetch_assoc()['statusName'];
            }
            else {
                $row["status"] = "Status is NULL";
            }

            $cardTypeID = $row["cardType"];
            $cardTypeResult = $cardType->getCardTypesByID($cardTypeID);
            if ($cardTypeResult->num_rows > 0)
            {
                $row["cardType"] = $cardTypeResult->fetch_assoc()['typeName'];
            }
            else {
                $row["status"] = "Card Type is NULL";
            }*/

            $dbdata[]=$row;
        }
    }
    else {
        $dbata[0] = "No messages";
    }

    echo json_encode($dbdata);
}
