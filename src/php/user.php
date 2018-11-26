<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/3/2018
 * Time: 10:18 PM
 */
require_once('dB.php');
class user
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
     * Get all users from database
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllUsers()
    {
        $result = self::$dbInterface -> query("SELECT userID, userName, email FROM user");
        return $result;
    }

    /**
    * Get user by email from database
    *
    * @param $email The users email
     * @return mixed The result of the mysqli::query() function
    */
    public function getUserIdByEmail($email)
    {
        $result = self::$dbInterface -> query("SELECT userID FROM user WHERE email='".$email."'");
        return $result;
    }

    /**
     * Get user by name from database
     *
     * @param $userName The users name
     * @return mixed The result of the mysqli::query() function
     */
    public function getUserIdByUserName($userName)
    {
        $result = self::$dbInterface -> query("SELECT userID FROM user WHERE userName='".$userName."'");
        return $result;
    }

    /** Get userName by userID
     *
     * @param $userID The userID
     * @return mixed The result of the mysqli::query() function
     */
     public function getUserNameByUserID($userID)
     {
         $result = self::$dbInterface -> query("SELECT userName FROM user WHERE userID='".$userID."'");
         return $result;
     }

    /**
     * Add user to user table in the database
     *
     * @param $email The users name
     * @param $userName The users email
     * @return mixed The result of the mysqli::query() function
     */
    public function addUser($email, $userName)
    {
        $result = self::$dbInterface -> query("INSERT INTO user (userID, email, userName, createdOn) VALUES (DEFAULT ,'".$email."', '".$userName."', now())");
        return $result;
    }

    /**
     * Remove user by email
     *
     * @param $email The users email
     * @return mixed The result of the mysqli::query() function
     */
    public function removeUser($email)
    {
        $result = self::$dbInterface -> query("DELETE FROM user WHERE email='".$email."'");
        return $result;
    }

    /**
     * Get check if userID is in database
     *
     * @param $userID the userID
     * @return mixed The result of the mysqli::query() function
     */
    public function exists($userID)
    {
        $result = self::$dbInterface->query("SELECT userID FROM user WHERE userID = '" . $userID . "'");
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}