<?php
// edit card script
// include required classes:
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

// Get posted values
$cardName = $_POST["Title"];
$description = $_POST["Description"];
$statusName = $_POST["Status"];
$ownerID = $_POST["Owner"];
$cardID = $_POST["cardID"];

// echo "<br>" . "Testing cardName: " . $cardName . "<br>";

// Get StatusID
$statusResult = $status->getStatusByName($statusName);
if ($statusResult->num_rows > 0) {
    $statusID = $statusResult->fetch_assoc()['statusID'];
} else {
    $statusID = NULL;
}

// note: to update any field we require all have valid values ...
if ($cardID && $cardName && $description && $statusID) {
    $result = $card->updateCardName($cardID, $cardName);
    $result = $card->updateCardDescription($cardID, $description);
    $result = $card->updateCardStatus($cardID, $statusID);
}

