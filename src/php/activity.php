<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/18/2018
 * Time: 9:23 PM
 */

require_once('dB.php');

class activity
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
     * Get all activity from database (activityID, content, time, user_userID, card_cardID)
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllActivity()
    {
        $result = self::$dbInterface -> query("SELECT activityID, content, time, user_userID, card_cardID 
              FROM activity");
        return $result;
    }

    /**
     * Get all messages from database in reverse chronological order
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllActivityReverse()
    {
        $result = self::$dbInterface -> query("SELECT activityID, content, time, user_userID, card_cardID 
          FROM activity ORDER BY activityID DESC");
        return $result;
    }

    /**
     * Get activity by activityID from database
     *
     * @param activityID The activityID
     * @return mixed The result of the mysqli::query() function
     */
    public function getActivityByID($activityID)
    {
        $result = self::$dbInterface -> query("SELECT activityID, content, time, user_userID, card_cardID 
              FROM activity WHERE activityID='$activityID'");
        return $result;
    }

    /**
     * Get check an activityID is in database
     *
     * @param $activityID the activityID
     * @return mixed The result of the mysqli::query() function
     */
    public function exists($activityID)
    {
        $result = self::$dbInterface->query("SELECT activityID FROM activity WHERE activityID = '" . $activityID . "'");
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Get activity for a specific userID
     *
     * @param userID The userID
     * @return mixed The result of the mysqli::query() function
     */
    public function getActivityForUser($userID)
    {
        $result = self::$dbInterface -> query("SELECT activityID, content, time, user_userID, card_cardID 
              FROM activity WHERE user_userID='$userID'");
        return $result;
    }

    /**
     * Get all messages from database in reverse chronological order
     *
     * @param userID The userID
     * @return mixed The result of the mysqli::query() function
     */
    public function getActivityForUserReverse($userID)
    {
        $result = self::$dbInterface -> query("SELECT activityID, content, time, user_userID, card_cardID 
          FROM activity WHERE user_userID='$userID' ORDER BY activityID DESC");
        return $result;
    }

    /**
     * Get activity for a specific cardID
     *
     * @param cardID The cardID
     * @return mixed The result of the mysqli::query() function
     */
    public function getActivityForCard($cardID)
    {
        $result = self::$dbInterface -> query("SELECT activityID, content, time, user_userID, card_cardID 
              FROM activity WHERE card_cardID='$cardID'");
        return $result;
    }

    /**
     * Get all messages from database in reverse chronological order
     *
     * @param cardID The cardID
     * @return mixed The result of the mysqli::query() function
     */
    public function getActivityForCardReverse($cardID)
    {
        $result = self::$dbInterface -> query("SELECT activityID, content, time, user_userID, card_cardID 
          FROM activity WHERE card_cardID='$cardID' ORDER BY activityID DESC");
        return $result;
    }

    /**
     * Add activity
     *
     * @param $content
     * @param $userID
     * @param $cardID
     * @return mixed The result of the mysqli::query() function
     */
    public function addActivity($content, $userID, $cardID)
    {
        $result = self::$dbInterface -> query("INSERT INTO activity (activityID, content, time, user_userID, card_cardID) 
                                                VALUES (DEFAULT, '".$content."',  now(), '".$userID."',
                                                '".$cardID."')");
        return $result;
    }
}
