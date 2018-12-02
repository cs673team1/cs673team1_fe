<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 12/1/2018
 * Time: 9:34 PM
 */

require_once('dB.php');

class comment
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
     * Get all comments from database (commentID, comment, card_cardID, user_userID)
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllComments()
    {
        $result = self::$dbInterface -> query("SELECT commentID, comment, card_cardID, user_userID 
              FROM comment");
        return $result;
    }

    /**
     * Get all comments from database in reverse chronological order(commentID, comment, card_cardID, user_userID)
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllCommentsReverse()
    {
        $result = self::$dbInterface -> query("SELECT commentID, comment, card_cardID, user_userID 
              FROM comment ORDER BY commentID DESC");
        return $result;
    }

    /**
     * Get comment by commentID from database
     *
     * @param commentID The commentID
     * @return mixed The result of the mysqli::query() function
     */
    public function getCommentByID($commentID)
    {
        $result = self::$dbInterface -> query("SELECT commentID, comment, card_cardID, user_userID 
              FROM comment WHERE commentID='$commentID'");
        return $result;
    }

    /**
     * Get check an commentID is in database
     *
     * @param $commentID the commentID
     * @return mixed The result of the mysqli::query() function
     */
    public function exists($commentID)
    {
        $result = self::$dbInterface->query("SELECT commentID FROM comment WHERE commentID = '" . $commentID . "'");
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Get comments for a specific userID
     *
     * @param userID The userID
     * @return mixed The result of the mysqli::query() function
     */
    public function getCommentsForUser($userID)
    {
        $result = self::$dbInterface -> query("SELECT commentID, comment, card_cardID, user_userID 
              FROM comment WHERE user_userID='$userID'");
        return $result;
    }

    /**
     * Get all comments for userID from database in reverse chronological order
     *
     * @param userID The userID
     * @return mixed The result of the mysqli::query() function
     */
    public function getCommentsForUserReverse($userID)
    {
        $result = self::$dbInterface -> query("SELECT commentID, comment, card_cardID, user_userID 
          FROM comment WHERE user_userID='$userID' ORDER BY commentID DESC");
        return $result;
    }

    /**
     * Get comments for a specific cardID
     *
     * @param cardID The cardID
     * @return mixed The result of the mysqli::query() function
     */
    public function getCommentsForCard($cardID)
    {
        $result = self::$dbInterface -> query("SELECT commentID, comment, card_cardID, user_userID 
              FROM comment WHERE card_cardID='$cardID'");
        return $result;
    }

    /**
     * Get all comments from database in reverse chronological order
     *
     * @param cardID The cardID
     * @return mixed The result of the mysqli::query() function
     */
    public function getCommentsForCardReverse($cardID)
    {
        $result = self::$dbInterface -> query("SELECT commentID, comment, card_cardID, user_userID 
          FROM comment WHERE card_cardID='$cardID' ORDER BY commentID DESC");
        return $result;
    }

    /**
     * Add comment
     *
     * @param $comment
     * @param $cardID
     * @param $userID
     * @return mixed The result of the mysqli::query() function
     */
    public function addComment($comment, $cardID, $userID)
    {
        $result = self::$dbInterface -> query("INSERT INTO comment (commentID, comment, card_cardID, user_userID) 
                                                VALUES (DEFAULT, '".$comment."', '".$cardID."', '".$userID."')");
        return $result;
    }
}