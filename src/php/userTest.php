<?php
/**
 * Created by PhpStorm.
 * User: kevko
 * Date: 11/25/2018
 * Time: 4:16 PM
 */

use PHPUnit\Framework\TestCase;
require_once('dB.php');
require_once('user.php');

// Note to run these tests, change the db.php object to run remotely and to
// poinit to your test database. Model it after the lines that point it to the
// "kevin" database. -or- have a working database set up on your local machine.
class userTest extends TestCase
{
    protected $db;
    protected $user;
    protected $addedUserName = "Joe Blow";
    protected $addedEmail = "jblow@bu.edu";
    protected const num_users = 6;

    protected function setUp()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $this->db = new dB();
        $this->user = new user($this->db);
    }

    public function test__construct()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $this->assertTrue($this->user != null );
    }

    public function testAddUser()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $result = $this->user->getUserIdByEmail($this->addedEmail);
        $result2 = $this->user->getUserIdByUserName($this->addedUserName);
        $this->assertEquals(0, $result->num_rows,"email is already in use.");
        $this->assertEquals(0, $result2->num_rows,"userName is already in use.");
        /* Beware - every time this code is run, it consumes a userID in the database. */
//        $result = $this->user->addUser($this->addedEmail, $this->addedUserName);
//        $this->assertTrue($result, "Could not add user" );
//        $result = $this->user->getUserIdByEmail($this->addedEmail);
//        $result2 = $this->user->getUserIdByUserName($this->addedUserName);
//        $this->assertEquals(1, $result->num_rows,"Couldn't find the added email.");
//        $this->assertEquals(1, $result2->num_rows,"Couldn't find the added userName");
    }

    /**
     * @depends  testAddUser
     */
    public function testRemoveUser()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        /* If you add a user above, these two lines should be run to remove the user. */
        /*
         *  Note this may have found a potential bug, the query passes even if there is
         * no matching entry to remove. - Not necessary at this time. It is not a requirement.
         */
        $result = $this->user->removeUser($this->addedEmail);
        $this->assertTrue($result, "Could not delete user." );

        $result = $this->user->getUserIdByEmail($this->addedEmail);
        $result2 = $this->user->getUserIdByUserName($this->addedUserName);
        $this->assertEquals(0, $result->num_rows,"Added email is still found!");
        $this->assertEquals(0, $result2->num_rows,"Added userName is still found!");
    }

//    /**
//     * @depends testRemoveUser
//     */
    public function testGetAllUsers()
    {
        /* Test get all users */
        fwrite(STDOUT, __METHOD__ . "\n");
        $allUsers = $this->user->getAllUsers();
        $this->assertEquals(self::num_users, $allUsers->num_rows);
        return $allUsers;
    }

    /**
     * This function produces a print tobe used by the data provider.
     * If the testPredefinedUsersList() tset fails, take the output
     * from this function and paste it over the table in the
     * usernameProvider() data provider. Then inspect the table to
     * make sure it is correct.
     * @depends  testGetAllUsers
     */
    public function testGetAllUsersCaptureData($allUsers)
    {
        while ($row = $allUsers->fetch_assoc()) {
            echo "\t\"usr #".$row["userID"]."\" => ";
            echo "[\"".$row["userID"]."\", \"".$row["userName"]."\", \"". $row["email"] . "\"],\n";
        }
        $allUsers->data_seek(0);
        $this->assertEquals(self::num_users, $allUsers->num_rows);
    }

    /**
     * @depends  testGetAllUsers
     * @dataProvider usernameProvider
     * @depends testGetAllUsersCaptureData
     */
    public function testPredefinedUsersList($userID, $userName, $email, $allUsers)
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $row = $allUsers->fetch_assoc();
        echo "\t\"usr #".$row["userID"]."\" => ";
        echo "[\"".$row["userID"]."\", \"".$row["userName"]."\", \"". $row["email"] . "\"],\n";
        $this->assertSame($userName, $row["userName"], "FAIL userName: ".$userName." != ".$row["userName"]);
//        $this->assertSame($userID, $row["userID"],     "FAIL ID: ".$userID." != ".$row["userID"]);
        $this->assertSame($email, $row["email"],       "FAIL email: ".$email." != ".$row["email"]);
    }

    /**
     * This data provider contains a table that was produced
     * by the testGetAllUsersCaptureData() test. If the data
     * changes in teh database, cut the output of the
     * testGetAllUsersCaptureData() and paste it here. Then
     * inspect it to make sure it makes sense.
     *
     */
    public function usernameProvider()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        return [
            "usr #1" => ["1", "Andrew Altizer", "aaltizer@bu.edu"],
            "usr #2" => ["2", "Allen Bouchard", "abouch@bu.edu"],
            "usr #3" => ["3", "Lynn Cistulli", "lynncistulli@gmail.com"],
            "usr #4" => ["4", "Kevin Koffink", "kkoffink@bu.edu"],
            "usr #5" => ["5", "Jon Shapiro", "jonathan_shapiro_public@comcast.net"],
            "usr #6" => ["6", "Ron Czik", "rec@bu.edu"],
        ];
    }

    public function testGetUserIdByEmail()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $goodEmail = "lynncistulli@gmail.com";
        $badEmail = "lynn@gmail.com";
        $usrIDExpected = "3";
        $result = $this->user->getUserIdByEmail($goodEmail);
        $this->assertEquals(1, $result->num_rows);
        $userID = $result->fetch_assoc()['userID'];
        $this->assertEquals($usrIDExpected, $userID);
        $result = $this->user->getUserIdByEmail($badEmail);
        $this->assertEquals(0, $result->num_rows);

    }

    public function testGetUserIdByUserName()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $goodUserName = "Lynn Cistulli";
        $badUserName = "Lynn";
        $expectedUsrIDExpected = "3";
        $result = $this->user->getUserIdByUserName($goodUserName);
        $this->assertEquals(1, $result->num_rows);
        $userID = $result->fetch_assoc()['userID'];
        $this->assertEquals($expectedUsrIDExpected, $userID);
        $result = $this->user->getUserIdByUserName($badUserName);
        $this->assertEquals(0, $result->num_rows);
    }

    public function testGetUserNameByUserID()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $expectedUserName = "Lynn Cistulli";
        $usrID = "3";
        $result = $this->user->getUserNameByUserID($usrID);
        $this->assertEquals(1, $result->num_rows);
        $userName = $result->fetch_assoc()['userName'];
        $this->assertEquals($expectedUserName, $userName);
    }
}
