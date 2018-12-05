-- --------------------------------------------------------
-- Host:                         c3po.fedos.info
-- Server version:               10.1.23-MariaDB-9+deb9u1 - Raspbian 9.0
-- Server OS:                    debian-linux-gnueabihf
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for c3poDB
DROP DATABASE IF EXISTS `c3poDB`;
CREATE DATABASE IF NOT EXISTS `c3poDB` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `c3poDB`;

-- Dumping structure for table c3poDB.activity
DROP TABLE IF EXISTS `activity`;
CREATE TABLE IF NOT EXISTS `activity` (
  `activityID` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_userID` int(11) NOT NULL,
  `card_cardID` int(11) NOT NULL,
  PRIMARY KEY (`activityID`),
  KEY `activity_card` (`card_cardID`),
  KEY `activity_user` (`user_userID`),
  CONSTRAINT `activity_card` FOREIGN KEY (`card_cardID`) REFERENCES `card` (`cardID`),
  CONSTRAINT `activity_user` FOREIGN KEY (`user_userID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table c3poDB.activity: ~0 rows (approximately)
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;

-- Dumping structure for table c3poDB.card
DROP TABLE IF EXISTS `card`;
CREATE TABLE IF NOT EXISTS `card` (
  `cardID` int(11) NOT NULL AUTO_INCREMENT,
  `cardName` varchar(50) NOT NULL,
  `cardType` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `complexity` int(11) NOT NULL,
  `list_listID` int(11) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  PRIMARY KEY (`cardID`),
  KEY `card_list` (`list_listID`),
  KEY `fk_card_status` (`status`),
  KEY `fk_card_cardType` (`cardType`),
  KEY `fk_card_user` (`owner`),
  CONSTRAINT `card_list` FOREIGN KEY (`list_listID`) REFERENCES `list` (`listID`),
  CONSTRAINT `fk_card_cardType` FOREIGN KEY (`cardType`) REFERENCES `cardType` (`typeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_card_status` FOREIGN KEY (`status`) REFERENCES `status` (`statusID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_card_user` FOREIGN KEY (`owner`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- Dumping data for table c3poDB.card: ~36 rows (approximately)
/*!40000 ALTER TABLE `card` DISABLE KEYS */;
INSERT INTO `card` (`cardID`, `cardName`, `cardType`, `description`, `status`, `complexity`, `list_listID`, `owner`) VALUES
                                                                                                                            (23, 'Reconcile Database Diagrams', 1, 'Review Team 1 and Team 2 database diagrams, resolve differences and create a new relationship Entity Diagram in LucidChart (Lynn, with Allen)', 4, 3, 2, NULL),
                                                                                                                            (24, 'Draw table diagram', 1, 'Enter new relationship Entity diagram into vertabelo and generate create tables script (Allen)', 4, 1, 2, NULL),
                                                                                                                            (25, 'Setup database', 1, 'Setup the database on the server and create accounts for all users (Allen)', 4, 2, 2, NULL),
                                                                                                                            (26, 'Create Git repository', 1, 'Create Git hub repositories for merged project (Jonathan)', 4, 2, 2, NULL),
                                                                                                                            (27, 'Send out Git guide', 1, 'Send out Git guide (Jonathan)', 4, 3, 2, NULL),
                                                                                                                            (28, 'Update Trello', 1, 'Update Trello to reflect new stories (Lynn)', 4, 2, 2, NULL),
                                                                                                                            (29, 'Develop prototype web page', 1, 'Provide prototype html page for updated design(Andrew)', 4, 3, 2, NULL),
                                                                                                                            (30, 'Setup local development environments', 1, 'Set up local environments for using mysql, php, javascript, apache and a browser (all)', 4, 3, 2, NULL),
                                                                                                                            (31, 'User name/email chosen from web app and saved in d', 1, 'User identifiers should be retrieved from the database and displayed in the User Login dropdown', 4, 1, 2, NULL),
                                                                                                                            (32, 'The user can view user names and choose one via th', 1, 'User Login dropdown will display usernames and allow user to choose one to self-identify', 4, 1, 2, NULL),
                                                                                                                            (33, 'Display chat messages', 1, 'The user can view the latest existing chat messages including time, creator and content', 4, 1, 2, NULL),
                                                                                                                            (34, 'Store submitted chat messages in the database', 1, 'Messages (content, date/time, userName and projectName) are stored in a database.', 4, 1, 2, NULL),
                                                                                                                            (35, 'User can send message using web application', 1, 'The user can add a new chat message of 500 or less characters in size (also check for chat length > 0)', 4, 2, 2, NULL),
                                                                                                                            (36, 'User is not persistent in user session on the web ', 2, 'After submitting a chat message, the entire page refreshes. This causes the User Login options to reload and the current username is forgotten.', 4, 1, 3, NULL),
                                                                                                                            (37, 'Card table does not include Owner', 2, 'The card table needs to include a field for the card\'s owner', 1, 1, 3, NULL),
                                                                                                                            (38, 'Database connection parameters are unsecure', 2, 'The database connection parameters (including username and password) are stoed in an .ini file, which can be read by anyone. Need to be moved to a .php file.', 1, 1, 3, NULL),
                                                                                                                            (39, 'Current Iteration list', 1, 'The cards that belong to the Backlog list will be displayed in a single, scrollable pane.', 1, 1, 2, NULL),
                                                                                                                            (40, 'Backlog list', 1, 'The cards that belong to the Backlog list will be displayed in a single, scrollable pane.', 1, 1, 2, NULL),
                                                                                                                            (41, 'Bug list', 1, 'The cards that belong to the Bug list will be displayed in a single, scrollable pane.', 1, 1, 2, NULL),
                                                                                                                            (42, 'User can add a card to a list', 1, 'Users can add new cards to each of the lists using an "Add" button.', 1, 1, 2, NULL),
                                                                                                                            (43, 'Card properties', 1, 'Each card has title(50 char), type, description(500 char), owner, status, & complexity', 1, 2, 2, NULL),
                                                                                                                            (44, 'Sending chat unreliable', 2, 'Chat becomes none responsive at times (Did not accept messages)', 1, 2, 3, NULL),
                                                                                                                            (45, 'Move cards', 1, 'User should be able to move cards between lists using a button or similar component.', 1, 2, 1, NULL),
                                                                                                                            (46, 'Edit/delete cards', 1, 'User should be able to edit or delete a card.', 1, 1, 1, NULL),
                                                                                                                            (47, 'Card comments', 1, 'User should be able to add comments to cards', 1, 2, 1, NULL),
                                                                                                                            (48, 'History', 1, 'System will keep a history of user actions', 1, 3, 1, NULL),
                                                                                                                            (49, 'Display history', 1, 'User should be able to display the history upon request', 1, 1, 1, NULL),
                                                                                                                            (50, 'User avatars', 1, 'Users should be able to choose an avatar to display with chat messages', 1, 2, 1, NULL),
                                                                                                                            (51, 'Bug  severity', 1, 'Cards of the Bug type will have a severity field', 1, 2, 1, NULL),
                                                                                                                            (52, 'Private messages', 1, 'Users should be able to send a message to another user priavtely', 1, 3, 1, NULL),
                                                                                                                            (53, 'Tag cards in messages', 1, 'Users should be able to add a tag to a message that points to a specific card', 1, 3, 1, NULL),
                                                                                                                            (54, 'New lists', 1, 'Users should be able to create new lists', 1, 2, 1, NULL),
                                                                                                                            (55, 'Status state machine', 1, 'The status that can be chosen will depend on the current status', 1, 3, 1, NULL),
                                                                                                                            (56, 'Status change restricted', 1, 'Only the card\'s owner can change the status', 1, 1, 1, NULL),
                                                                                                                            (57, 'Project metrics', 1, 'System will track and display metrics for the project', 1, 3, 1, NULL),
                                                                                                                            (68, 'DELETE', 2, 'FAKE BUG', 1, 0, 3, NULL);
/*!40000 ALTER TABLE `card` ENABLE KEYS */;

-- Dumping structure for table c3poDB.cardType
DROP TABLE IF EXISTS `cardType`;
CREATE TABLE IF NOT EXISTS `cardType` (
  `typeID` int(11) NOT NULL AUTO_INCREMENT,
  `typeName` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`typeID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table c3poDB.cardType: ~4 rows (approximately)
/*!40000 ALTER TABLE `cardType` DISABLE KEYS */;
INSERT INTO `cardType` (`typeID`, `typeName`) VALUES
                                                     (1, 'Feature'),
                                                     (2, 'Bug'),
                                                     (3, 'Task'),
                                                     (4, 'Release');
/*!40000 ALTER TABLE `cardType` ENABLE KEYS */;

-- Dumping structure for table c3poDB.comment
DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(500) NOT NULL,
  `card_cardID` int(11) NOT NULL,
  `user_userID` int(11) NOT NULL,
  PRIMARY KEY (`commentID`),
  KEY `comment_card` (`card_cardID`),
  KEY `comment_user` (`user_userID`),
  CONSTRAINT `comment_card` FOREIGN KEY (`card_cardID`) REFERENCES `card` (`cardID`),
  CONSTRAINT `comment_user` FOREIGN KEY (`user_userID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table c3poDB.comment: ~1 rows (approximately)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` (`commentID`, `comment`, `card_cardID`, `user_userID`) VALUES
                                                                                    (1, 'Unable to replicate. Need more information.', 44, 2);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;

-- Dumping structure for table c3poDB.list
DROP TABLE IF EXISTS `list`;
CREATE TABLE IF NOT EXISTS `list` (
  `listID` int(11) NOT NULL AUTO_INCREMENT,
  `listName` varchar(50) NOT NULL,
  `project_projectID` int(11) NOT NULL,
  PRIMARY KEY (`listID`),
  KEY `list_project` (`project_projectID`),
  CONSTRAINT `list_project` FOREIGN KEY (`project_projectID`) REFERENCES `project` (`projectID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table c3poDB.list: ~3 rows (approximately)
/*!40000 ALTER TABLE `list` DISABLE KEYS */;
INSERT INTO `list` (`listID`, `listName`, `project_projectID`) VALUES
                                                                      (1, 'Backlog', 1),
                                                                      (2, 'Current Iteration', 1),
                                                                      (3, 'Bugs', 1),
                                                                      (4, 'Archive', 1);
/*!40000 ALTER TABLE `list` ENABLE KEYS */;

-- Dumping structure for table c3poDB.message
DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
  `timeSent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_userID` int(11) NOT NULL,
  `project_projectID` int(11) NOT NULL,
  PRIMARY KEY (`messageID`),
  KEY `message_project` (`project_projectID`),
  KEY `message_user` (`user_userID`),
  CONSTRAINT `message_project` FOREIGN KEY (`project_projectID`) REFERENCES `project` (`projectID`),
  CONSTRAINT `message_user` FOREIGN KEY (`user_userID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table c3poDB.message: ~13 rows (approximately)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` (`messageID`, `content`, `timeSent`, `user_userID`, `project_projectID`) VALUES
                                                                                                      (20, 'hello, This is a test', '2018-11-14 21:15:25', 3, 1),
                                                                                                      (21, 'Hello Lynn.... thank you for the test message. I hope you enjoy the rest of your day.', '2018-11-15 10:28:34', 1, 1),
                                                                                                      (22, 'All cards in Trello have been copied to the database.', '2018-11-17 10:44:54', 2, 1),
                                                                                                      (23, 'I have added exists() functions to the card, cardType and status classes. The functions check to see if the "ID" is in the database for the three classes.', '2018-11-17 16:25:39', 3, 1),
                                                                                                      (24, 'I have also added functions to update cardType and card status to the card class', '2018-11-17 16:26:49', 3, 1),
                                                                                                      (25, 'Sorry about the navbar. Form over function until we get it working.', '2018-11-18 15:12:37', 2, 1),
                                                                                                      (26, 'JS test 18-Nov-2018', '2018-11-18 15:42:15', 5, 1),
                                                                                                      (27, 'hi from kevin', '2018-11-20 19:24:22', 4, 1),
                                                                                                      (28, 'Testing refresh capability', '2018-11-20 19:24:25', 3, 1),
                                                                                                      (29, 'Hello  Test\n', '2018-11-20 19:25:29', 1, 1),
                                                                                                      (30, 'Hello from Jon 20-Nov-2018', '2018-11-20 19:25:31', 5, 1),
                                                                                                      (31, 'JS test 24 Nov', '2018-11-24 15:03:47', 5, 1),
                                                                                                      (32, 'Jonathan, are you still having issues with newBug.php? I noticed that it still does not use the POSTs.', '2018-11-25 11:42:28', 3, 1);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

-- Dumping structure for table c3poDB.project
DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `projectID` int(11) NOT NULL AUTO_INCREMENT,
  `projectName` varchar(50) NOT NULL,
  PRIMARY KEY (`projectID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table c3poDB.project: ~0 rows (approximately)
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` (`projectID`, `projectName`) VALUES
                                                          (1, 'The Project');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;

-- Dumping structure for table c3poDB.status
DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `statusID` int(11) NOT NULL AUTO_INCREMENT,
  `statusName` varchar(15) NOT NULL,
  PRIMARY KEY (`statusID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table c3poDB.status: ~5 rows (approximately)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`statusID`, `statusName`) VALUES
                                                       (1, 'Open'),
                                                       (2, 'In-Work'),
                                                       (3, 'Work-Done'),
                                                       (4, 'Test-Pass'),
                                                       (5, 'Test-Fail');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;

-- Dumping structure for table c3poDB.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(320) NOT NULL,
  `userName` varchar(80) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`),
  KEY `User_idx_1` (`email`(191))
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- Dumping data for table c3poDB.user: ~5 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`userID`, `email`, `userName`, `createdOn`, `lastLogin`) VALUES
                                                                                    (1, 'aaltizer@bu.edu', 'Andrew Altizer', '2018-10-26 18:39:35', '2018-10-26 18:39:35'),
                                                                                    (2, 'abouch@bu.edu', 'Allen Bouchard', '2018-10-26 18:45:29', '2018-10-26 18:45:29'),
                                                                                    (3, 'lynncistulli@gmail.com', 'Lynn Cistulli', '2018-10-26 18:46:32', '2018-10-26 18:46:43'),
                                                                                    (4, 'kkoffink@bu.edu', 'Kevin Koffink', '2018-10-26 18:47:30', '2018-10-26 18:47:30'),
                                                                                    (5, 'jonathan_shapiro_public@comcast.net', 'Jon Shapiro', '2018-10-26 18:48:23', '2018-10-26 18:48:23');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table c3poDB.user_project
DROP TABLE IF EXISTS `user_project`;
CREATE TABLE IF NOT EXISTS `user_project` (
  `userID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  PRIMARY KEY (`userID`,`projectID`),
  KEY `user_project_project` (`projectID`),
  CONSTRAINT `user_project_project` FOREIGN KEY (`projectID`) REFERENCES `project` (`projectID`),
  CONSTRAINT `user_project_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table c3poDB.user_project: ~5 rows (approximately)
/*!40000 ALTER TABLE `user_project` DISABLE KEYS */;
INSERT INTO `user_project` (`userID`, `projectID`) VALUES
                                                          (1, 1),
                                                          (2, 1),
                                                          (3, 1),
                                                          (4, 1),
                                                          (5, 1);
/*!40000 ALTER TABLE `user_project` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
