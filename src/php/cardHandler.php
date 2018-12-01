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
require_once ('lists.php');
require_once ('activity.php');


$db = new dB();
$user = new user($db);
$project = new project($db);
$card = new card($db);
$status = new status($db);
$cardType = new cardType($db);
$list = new lists($db);
$activity = new activity($db);

$request = $_POST["request"];

if ($request == "get")
{
    if (isset($_POST["listname"]))
    {
        $listName = $_POST["listname"];
        $result = $list->getListIdByName($listName);
        $row = $result->fetch_assoc();
        $listID = $row["listID"];
        $result = $card->getCardsForList($listID);
    } elseif (isset($_POST["cardid"]))
    {
        $result = $card->getCardByID($_POST["cardid"]);
    }
    else {
        $result = $card->getAllCards();
    }

    // The array that holds the JSON data (Note: not in JSON format until encoded)
    $dbdata = array();

    if ($result->num_rows > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())
        {
            $statusID = $row["status"];
            $statusResult = $status->getStatusByID($statusID);
            if ($statusResult->num_rows > 0)
            {
                $row["status"] = $statusResult->fetch_assoc()['statusName'];
            }
            else {
                $row["status"] = "Status is NULL";
            }

            $cardTypeID = $row["cardType"];
            $cardTypeResult = $cardType->getCardTypeByID($cardTypeID);
            if ($cardTypeResult->num_rows > 0)
            {
                $row["cardType"] = $cardTypeResult->fetch_assoc()['typeName'];
            }
            else {
                $row["status"] = "Card Type is NULL";
            }

            $userID = $row["owner"];
            $userResult = $user->getUserNameByUserID($userID);
            if ($userResult->num_rows > 0)
            {
                $row["owner"] = $userResult->fetch_assoc()['userName'];
            }
            else {
                $row["owner"] = "None";
            }

            $dbdata[]=$row;
        }
    }
    else {
        $dbata[0] = "No messages";
    }

    echo json_encode($dbdata);
} elseif ($request == "move")
{
    $cardID = $_POST["cardid"];

    $result = $card->getCardList($cardID);
    $row = $result->fetch_assoc();
    $currentListID = $row["list_listID"];

    $result = $list->getListNameByListID($currentListID);
    $row = $result->fetch_assoc();
    $currentList = $row["listName"];

    $result = $card->getCardType($cardID);
    $row = $result->fetch_assoc();
    $cardTypeID = $row["cardType"];

    $result = $cardType->getCardTypeByID($cardTypeID);
    $row = $result->fetch_assoc();
    $cardTypeName = $row["typeName"];

    if ($currentList == "Bugs")
    {
        $newList = "Current Iteration";
    } elseif ($currentList == "Backlog")
    {
        $newList = "Current Iteration";
    } elseif ($currentList == "Current Iteration" && $cardTypeName == "Bug")
    {
        $newList = "Bugs";
    } elseif ($currentList == "Current Iteration" && $cardTypeName == "Feature")
    {
        $newList = "Backlog";
    }

    if (isset($newList))
    {
        echo "Moving Card $cardID from $currentList to $newList";

        $result = $list->getListIdByName($newList);
        $row = $result->fetch_assoc();
        $newListID = $row["listID"];
        $card->updateCardList($cardID, $newListID);
    }
    else{
        echo "newList not set\n";
    }
}elseif ($request == "delete")
{
    $cardID = $_POST["cardid"];

    $newList = "Archive";
    $result = $list->getListIdByName($newList);
    $row = $result->fetch_assoc();
    $newListID = $row["listID"];
    $card->updateCardList($cardID, $newListID);
    // $card->deleteCardByID($cardID);

    // Add activity for archiving the bug
    //get userID
    //$userName = $_POST["UserName"];
    //$userResult = $user->getuserIDByUserName($userName);
    //if ($userResult->num_rows > 0) {
       // $userID = $userResult->fetch_assoc()['userID'];
   // } else {
        //$userID = NULL;
    //}
    $userID = 3;
    // get cardName
    $cardResult = $card->getCardByID($cardID);
    if ($cardResult->num_rows > 0) {
        $cardName = $cardResult->fetch_assoc()['cardName'];
    } else {
        $cardName = NULL;
    }

    $action = "archived";
    if ($cardID && $userID) {
        $content = $userName . " " . $action . " " . $cardName ."(" . $cardID . ") ";
        $activityResult = $activity->addActivity($content, $userID, $cardID);
    }
}

