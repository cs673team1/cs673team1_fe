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
            self::$dbInterface = $db;
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

    /** Get status by statusID
     *
     * @param $statusID Integer statusID
     * @return mixed The result of the mysqli::query() function
     */
    public function getStatusByID($statusID)
    {
        $result = self::$dbInterface -> query("SELECT statusName FROM status WHERE statusID='".$statusID."'");
        return $result;
    }

    /** Get status by statusName
     *
     * @param $statusName ... name of the status
     * @return mixed of the mysqli::query() function
     */
    public function getStatusByName($statusName)
    {
        $result = self::$dbInterface -> query("SELECT statusID FROM status WHERE statusName='".$statusName."'");
        return $result;
    }

    /**
     * Check if statusID exists in database
     *
     * @param $statusID Integer statusID
     * @return boolean 1 if statusID exists 0 if it doesn't exist
     */
    public function exists($statusID)
    {
        $result = self::$dbInterface->query("SELECT statusID FROM status WHERE statusID = '" . $statusID . "'");
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }


}