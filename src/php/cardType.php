<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/14/2018
 * Time: 12:49 AM
 */
require_once('dB.php');

class cardType
{
    // The database interface
    protected static $dbInterface;

    function __construct($db)
    {
        // Try and connect to the database interface
        if (!isset(self::$dbInterface)) {
            Self::$dbInterface = $db;
        }

        // If database interface was not successful, handle the error
        if (self::$dbInterface === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return false;
        }
        return self::$dbInterface;
    }

    /**
     * Get all cardTypes from database
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllCardTypes()
    {
        $result = self::$dbInterface -> query("SELECT typeID, typeName FROM cardType");
        return $result;
    }

    public function getCardTypesByID($cardTypeID)
    {
        $result = self::$dbInterface -> query("SELECT typeName FROM cardType WHERE typeID=$cardTypeID");
        return $result;
    }
}