<?php

/* include required classes */
require_once('dB.php');
require_once('user.php');
require_once('project.php');
require_once('card.php');
require_once ('status.php');
require_once ('cardType.php');
require_once ('lists.php');

$db = new dB();
$user = new user($db);
$project = new project($db);
$card = new card($db);
$status = new status($db);
$cardType = new cardType($db);
$list = new lists($db);

/* Default  Values */
$typeName = "Bug";
$listName = "Bugs";
$complexity = "4";

/* Get typeID */
$typeResult = $cardType->getTypeIDByName($typeName);
if ($typeResult->num_rows > 0)
{
    $typeID = $typeResult->fetch_assoc()['typeID'];
} else {
    $typeID = NULL;
}

/* Get ListID */
$listResult = $list->getListIdByName($listName);
if ($listResult->num_rows > 0)
{
    $listID = $listResult->fetch_assoc()['listID'];
} else {
    $listID = NULL;
}

/* Get posted values */
$cardName = $_POST["cardName"];
$description = $_POST["description"];
$status = $_POST["status"];

/* Get StatusID */
$statusResult = $list->getListIdByName($statusName);
if ($statusResult->num_rows > 0)
{
    $statusID = $statusResult->fetch_assoc()['statusID'];
} else {
    $statusID = NULL;
}

if ($statusID !== NULL AND $listID !== NULL AND $typeID !== NULL)
{
    $result = $card->addCardToList($cardName, $typeID, $description, $statusID, $complexity, $listID);
}



