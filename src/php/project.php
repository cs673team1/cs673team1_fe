<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/4/2018
 * Time: 11:45 AM
 */
require_once('dB.php');
class project
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
     *  Get All projects
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllProjects()
    {
        $result = self::$dbInterface -> query("SELECT projectID, projectName FROM project");
        return $result;
    }

    /**
     * Get a projectID by projectName from database
     *
     * @param $projectName The projectName
     * @return mixed The result of the mysqli::query() function
     */
    public function getProjectIdByName($projectName)
    {
        $result = self::$dbInterface -> query("SELECT projectID FROM project WHERE projectName='".$projectName."'");
        return $result;
    }

    /** Get projectName by projectID
     *
     * @param $projectID The projectID
     * @return mixed The result of the mysqli::query() function
     */
    public function getProjectNameByProjectID($projectID)
    {
        $result = self::$dbInterface -> query("SELECT projectName FROM project WHERE projectID='".$projectID."'");
        return $result;
    }

    /**
     * Add project to project table in the database
     *
     * @param $projectName
     * @return mixed The result of the mysqli::query() function
     */
    public function addProject($projectName)
    {
        $result = self::$dbInterface -> query("INSERT INTO project (projectID, projectName) VALUES (DEFAULT , '".$projectName."')");
        return $result;
    }

    /**
     * Remove project by projectName
     *
     * @param $projectName The projectName
     * @return mixed The result of the mysqli::query() function
     */
    public function removeProject($projectName)
    {
        $result = self::$dbInterface -> query("DELETE FROM project WHERE projectName='".$projectName."'");
        return $result;
    }

    /**
     * Add User to a project
     *
     * @param $userID The userID
     * @param $projectName The projectName
     * @return mixed The result of the mysqli::query() function
     */
     public function addUserIDToProject($userID, $projectName)
     {
         $result = self::getProjectIdByName($projectName);
         if ($result->num_rows > 0) {
             $projectID = $result->fetch_assoc()['projectID'];
             echo 'projectID = ' . $projectID . "<br>";
             $result = self::$dbInterface -> query("INSERT INTO user_project (userID, projectID) VALUES ('".$userID."', ".$projectID.")");
             return $result;
         }else {
             return false;
         }
     }

}