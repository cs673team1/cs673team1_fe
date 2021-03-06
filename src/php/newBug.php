<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/24/2018
 * Time: 4:01 PM
 */
/* New bug script */
/* to do: combine common code for newStory, newBug and editCard */
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

// Default  Values
$typeName = "Bug";
$listName = "Bugs";
$statusName = "Status";
$complexity = 4;

// Get typeID
$typeResult = $cardType->getTypeIDByName($typeName);
if ($typeResult->num_rows > 0) {
    $typeID = $typeResult->fetch_assoc()['typeID'];
} else {
    $typeID = NULL;
}

// Get ListID
$listResult = $list->getListIdByName($listName);
if ($listResult->num_rows > 0) {
    $listID = $listResult->fetch_assoc()['listID'];
} else {
    $listID = NULL;
}

// test point:
//$result = $card->addCardToList("DELETE", $typeID, "FAKE BUG 2", 1, 4, $listID);
// note: can easily comment out using /* ... */ if all comments are line comments using //

// Get posted values
$cardName = $_POST["Title"];
$description = $_POST["Description"];
$statusName = $_POST["Status"];
$owner = $_POST["Owner"];
$statusID = 1; // Open is value 1
$userName = $_POST["UserName"];

// echo "<br>" . "Testing cardName: " . $cardName . "<br>";

// Get statusID
$statusResult = $status->getStatusByName($statusName);
if ($statusResult->num_rows > 0) {
    $statusID = $statusResult->fetch_assoc()['statusID'];
} else {
    $statusID = 1;
}

//get ownerID
$userResult = $user->getuserIDByUserName($owner);
if ($userResult->num_rows > 0) {
    $ownerID = $userResult->fetch_assoc()['userID'];
} else {
    $ownerID = NULL;
}

if ($cardName && $typeID && $description && $statusID && $complexity && $listID) {
    $result = $card->addCardToList($cardName, $typeID, $description, $statusID, $complexity, $listID, $ownerID );

    // Add new activity
    // Is getting the maximum cardID sufficient?
    $cardResult = $card->getMaxCardID();
    if ($cardResult->num_rows > 0) {
        $cardID = $cardResult->fetch_assoc()['MAX(cardID)'];
    } else {
        $cardID = NULL;
    }

    //get userID
    $userResult = $user->getuserIDByUserName($userName);
    if ($userResult->num_rows > 0) {
        $userID = $userResult->fetch_assoc()['userID'];
    } else {
        $userID = NULL;
    }

    $action = "added";
    if ($cardID && $userID) {
        $content = $userName . " " . $action . " " . $cardName ."(" . $cardID . ") to " . $listName;
        $activityResult = $activity->addActivity($content, $userID, $cardID);
    }
}
