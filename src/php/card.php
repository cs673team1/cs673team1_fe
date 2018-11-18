<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 11/13/2018
 * Time: 4:48 PM
 *
 * Revisions
 * User: Lynn
 * Date: 11/13/2018
 * Modifications: Added get and add functions
 */

require_once ('dB.php');
class card
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
     * Get all cards from database
     *
     * @return mixed The result of the mysqli::query() function
     */
    public function getAllCards()
    {
        $result = self::$dbInterface -> query("SELECT cardID, cardName, cardType, description, status, 
              complexity, list_listID FROM card");
        return $result;
    }

    /** Get Card by cardID
     *
     * @param $cardID The cardID
     * @return mixed The result of the mysqli::query() function
     */
    public function getCardByID($cardID)
    {
        $result = self::$dbInterface -> query("SELECT cardName, cardType, description, status, 
              complexity, list_listID FROM card WHERE cardID='".$cardID."'");
        return $result;
    }

    /**
     * Get check if card is in database
     *
     * @param $cardID the cardID
     * @return mixed The result of the mysqli::query() function
     */
    public function exists($cardID)
    {
        $result = self::$dbInterface->query("SELECT cardID FROM card WHERE cardID = '" . $cardID . "'");
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Get all cards from database for listID
     *
     * @param $listID the listID
     * @return mixed The result of the mysqli::query() function
     */
    public function getCardsForList($listID)
    {
        $result = self::$dbInterface -> query("SELECT cardID, cardName, cardType, description, status, 
             complexity, list_listID FROM card WHERE card.list_listID='".$listID."'");
        return $result;
    }

    /**
     * Get all cards from database for listID, statusID pairs
     *
     * @param $listID the listID
     * @param $statusID the status for the cards
     * @return mixed The result of the mysqli::query() function
     */
    public function getCardsForListWithStatus($listID, $statusID)
    {
        $result = self::$dbInterface -> query("SELECT cardID, cardName, cardType, description, status, 
             complexity, list_listID FROM card WHERE card.status='".$statusID."' and card.list_listID='".$listID."'");
        return $result;
    }


    /**
     * Add card to specific list
     *
     * @param $cardName
     * @param $typeID
     * @param $description
     * @param $statusID
     * @param $complexity
     * @param $listID
     * @return mixed The result of the mysqli::query() function
     */
    public function addCardToList($cardName, $typeID, $description, $statusID, $complexity, $listID)
    {
        $result = self::$dbInterface -> query("INSERT INTO card (cardID, cardName, cardType, description, status, 
                                                complexity, list_listID) 
                                                VALUES (DEFAULT, '".$cardName."', '".$typeID."', '".$description."',
                                                '".$statusID."', '".$complexity."', '".$listID."')");
        return $result;
    }

    /**
     * Update card status
     *
     * @param $cardID,
     * @param $status
     * @return mixed The result of the mysqli::query() function
     */
    public function updateCardStatus($cardID, $status)
    {
        $result = self::$dbInterface->query("UPDATE card SET status= '" . $status . "' WHERE cardID= '" . $cardID . "'");
        return $result;
    }

    /**
     * Update card type
     *
     * @param $cardID,
     * @param $cardType
     * @return mixed The result of the mysqli::query() function
     */
    public function updateCardType($cardID, $cardType)
    {
        $result = self::$dbInterface->query("UPDATE card SET cardType= '" . $cardType . "' WHERE cardID= '" . $cardID . "'");
        return $result;
    }

}