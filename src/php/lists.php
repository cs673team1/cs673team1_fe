<?php
/**
 * Created by PhpStorm.
 * User: allen
 * Date: 11/13/2018
 * Time: 4:52 PM
 */

require_once ('dB.php');
class lists
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
     * Get all lists from database
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllLists()
    {
        $result = self::$dbInterface -> query("SELECT listID, listName, project_projectID FROM list");
        return $result;
    }

    /**
     * Get all lists from database for projectID
     *
     * @param $projectID The projectID
     * @return mixed The result of the mysqli::query() function
     */
    public function getListsForProject($projectID)
    {
        $result = self::$dbInterface -> query("SELECT listID, listName, project_projectID FROM list WHERE project_projectID='".$projectID."'");
        return $result;
    }

    /**
     * Get a listID by listName from database
     *
     * @param $listName The listName
     * @return mixed The result of the mysqli::query() function
     */
    public function getListIdByName($listName)
    {
        $result = self::$dbInterface -> query("SELECT listID FROM list WHERE listName='".$listName."'");
        return $result;
    }

    /** Get listName by listID
     *
     * @param $listID The listID
     * @return mixed The result of the mysqli::query() function
     */
    public function getListNameByListID($projectID)
    {
        $result = self::$dbInterface -> query("SELECT projectName FROM project WHERE projectID='".$projectID."'");
        return $result;
    }




    /**
     * Add list to specific project for a specific user
     *
     * @param $content
     * @param $projectID
     * @param $userID
     * @return mixed The result of the mysqli::query() function
     */
    /*public function addMessage($content, $projectID, $userID)
    {
        $result = self::$dbInterface -> query("INSERT INTO message (messageID, content, timeSent, user_userID, project_projectID) 
                                                VALUES (DEFAULT, '".$content."', now(), '".$userID."', '".$projectID."')");
        return $result;
    }*/

}