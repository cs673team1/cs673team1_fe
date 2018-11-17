<?php
/**
 * Created by PhpStorm.
 * User: allen
 * Date: 11/13/2018
 * Time: 4:26 PM
 */

$db = new dB();
$user = new user($db);
$project = new project($db);


$request = $_POST['request'];

if ($request == "get")
{

}
