<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/4/2018
 * Time: 3:46 PM
 */
require_once('dB.php');
class message
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
     * Get all messages from database
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllMessages()
    {
        $result = self::$dbInterface -> query("SELECT messageID, content, timeSent, user_userID, project_projectID FROM message");
        return $result;
    }

    /**
     * Get all messages from database in reverse chronological order
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllMessagesReverse()
    {
        $result = self::$dbInterface -> query("SELECT messageID, content, timeSent, user_userID, project_projectID FROM message ORDER BY messageID DESC");
        return $result;
    }

    /**
     * Get all messages from database for projectID
     *
     * @param $projectID The projectID
     * @return mixed The result of the mysqli::query() function
     */
    public function getMessagesForProject($projectID)
    {
        $result = self::$dbInterface -> query("SELECT messageID, content, timeSent, user_userID, project_projectID FROM message WHERE project_projectID='".$projectID."'");
        return $result;
    }

    /**
     * Add message to specific project for a specific user
     *
     * @param $content
     * @param $projectID
     * @param $userID
     * @return mixed The result of the mysqli::query() function
     */
    public function addMessage($content, $projectID, $userID)
    {
        $result = self::$dbInterface -> query("INSERT INTO message (messageID, content, timeSent, user_userID, project_projectID) 
                                                VALUES (DEFAULT, '".$content."', now(), '".$userID."', '".$projectID."')");
        return $result;
    }
}