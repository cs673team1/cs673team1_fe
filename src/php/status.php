<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/14/2018
 * Time: 12:41 AM
 */
require_once('dB.php');

class status
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
     * Get all status values from database
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllStatus()
    {
        $result = self::$dbInterface -> query("SELECT statusID, statusName FROM status");
        return $result;
    }

    public function getStatusByID($statusID)
    {
        $result = self::$dbInterface -> query("SELECT statusName FROM status WHERE statusID=$statusID");
        return $result;
    }
}