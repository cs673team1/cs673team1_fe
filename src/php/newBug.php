<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/24/2018
 * Time: 4:01 PM
 */
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

$result = $card->addCardToList("DELETE", 1, "DELETE",1, 2, 1);