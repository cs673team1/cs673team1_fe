<?php
/**
 * Created by PhpStorm.
 * User: lynnc
 * Date: 11/3/2018
 * Time: 11:21 PM
 */
/* include required classes */
require_once('dB.php');
require_once('user.php');
require_once('project.php');
require_once('message.php');

$db = new dB();
$user = new user($db);
$project = new project($db);
$message = new message($db);

/* Test get all users */
echo "Testing get all users" . "<br>";
$result = $user->getAllUsers();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "userID: " . $row["userID"]. " - Name: " . $row["userName"]. " - Email: " . $row["email"]. "<br>";
    }
} else {
    echo "0 results";
}

/* Test Get userID by email */
$email = "lynncistulli@gmail.com";
echo "<br>" . "Testing get userID by email using email: " . $email . "<br>";
$result = $user->getUserIdByEmail($email);
if ($result->num_rows > 0)
{
    $userID = $result->fetch_assoc()['userID'];
    echo "userID: " . $userID . "<br>";
}else
{
    echo 'alert("User not found");';
    echo "<br>";
}

/* Test Get userID by email */
$email = "lynn@gmail.com";
echo "<br>" . "Testing get userID by email using email: " . $email . "<br>";
$result = $user->getUserIdByEmail($email);
if ($result->num_rows > 0)
{
    $userID = $result->fetch_assoc()['userID'];
    echo "userID: " . $userID . "<br>";
}else
{
    echo 'alert("User not found");';
    echo "<br>";
}

/* Test Get userID by userName */
$userName = "Lynn Cistulli";
echo "<br>" . "Testing get userID by email using userName: " . $userName . "<br>";
$result = $user->getUserIdByUserName($userName);
if ($result->num_rows > 0)
{
    $userID = $result->fetch_assoc()['userID'];
    echo "userID: " . $userID . "<br>";
}else
{
    echo 'alert("User not found");';
    echo "<br>";
}

/* Test Get userID by userName */
$userName = "Lynn";
echo "<br>" . "Testing get userID by email using userName: " . $userName . "<br>";
$result = $user->getUserIdByUserName($userName);
if ($result->num_rows > 0)
{
    $userID = $result->fetch_assoc()['userID'];
    echo "userID: " . $userID . "<br>";
}else
{
    echo 'alert("User not found");';
    echo "<br>";
}

/* Add user */
$userName = "Lynn";
$email = "lynn@gmail.com";
/* see if the gmail is already in use */
$result = $user->getUserIdByEmail($email);
$result2 = $user->getUserIdByUserName($userName);
if ($result->num_rows > 0) {
    echo "email is already in use" . "<br>";
}else if ($result2->num_rows> 0) {
    echo "userName is already in use" . "<br>";
}else {
    echo "<br>" . "Testing add user with: " . $email . " " . $userName . "<br>";
    $result = $user->addUser($email, $userName);
    if (!$result) {
        echo "alert(Could not enter user)";
        echo "<br>";
    } else {
        echo "Added user: " . $email . " " . $userName . "<br>";
    }
}

/* remove user */
$email = "lynn@gmail.com";
echo "<br>" . "Testing remove user: " . $email . "<br>";
$result = $user->removeUser($email);
if (!$result)
{
    echo "alert(Could not remove user)";
    echo "<br>";
} else
{
    echo "Removed user: " . $email . "<br>";
}

/* Test get all projects */
echo "<br>" ."Testing get all projects" . "<br>";
$result = $project->getAllProjects();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "projectID: " . $row["projectID"]. " - Name: " . $row["projectName"]. "<br>";
    }
} else {
    echo "0 results";
}

/* Test Get projectID by projectName */
$projectName = "testProject";
echo "<br>" . "Testing get projectID by projectName using projectName: " . $projectName . "<br>";
$result = $project->getProjectIdByName($projectName);
if ($result->num_rows > 0)
{
    $projectID = $result->fetch_assoc()['projectID'];
    echo "projectID: " . $projectID . "<br>";
}else {
    echo 'alert("User not found");';
    echo "<br>";
}

/* Test add project  */
$projectName = "testProject2";
echo "<br>" . "Testing add project: " . $projectName . "<br>";
$result = $project->AddProject($projectName);
if (!$result) {
    echo "alert(Could not enter project)";
    echo "<br>";
} else {
    echo "Added project: " . $projectName . "<br>";
}

/* remove project */
$projectName = "testProject2";
echo "<br>" . "Testing remove project: " . $projectName . "<br>";
$result = $project->removeProject($projectName);
if (!$result)
{
    echo "alert(Could not remove user)";
    echo "<br>";
} else
{
    echo "Removed project: " . $projectName . "<br>";
}


/* Add a user to a project */
$email = 'lynncistulli@gmail.com';
$projectName = 'testProject';
echo "<br>" . "Testing addUserIDToProject using email: " .$email. " project = " .$projectName."<br>";
$result = $user->getUserIdByEmail($email);
if ($result->num_rows > 0)
{
    $userID = $result->fetch_assoc()['userID'];
    echo "userID = " . $userID . "<br>";
    $result = $project->addUserIDToProject($userID, $projectName);
    if (!$result)
    {
        echo "alert (Could not add " . $email . " to project " . $projectName . ")<br>";
    }
}else
{
    echo 'alert("User email not found");';
    echo "<br>";
}

/* Test get all messages */
echo "Testing get all messages" . "<br>";
$result = $message->getAllMessages();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $userID = $row["user_userID"];
        $userNameResult = $user->getUserNameByUserID($userID);
        $projectID = $row["project_projectID"];
        $projectNameResult = $project->getProjectNameByProjectID($projectID);
        if ($userNameResult->num_rows > 0) {
            $userName = $userNameResult->fetch_assoc()['userName'];
            echo "" .$row["timeSent"]. "<br>   " .$userName. "<br>   " .$row["content"]. "<br> <br>";
        } else {
        echo 'alert("User name not found");';
        echo "<br>";
        }

}
} else {
    echo "0 results";
}

/* Test get all messages */
echo "Testing get all messages for projectName" . "<br>";
$projectName = "testProject";
$result = $project->getProjectIdByName($projectName);
if ($result->num_rows > 0) {
    $projectID = $result->fetch_assoc()['projectID'];
    $result = $message->getMessagesForProject($projectID);
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $userID = $row["user_userID"];
        $userNameResult = $user->getUserNameByUserID($userID);
        if ($userNameResult->num_rows > 0) {
            $userName = $userNameResult->fetch_assoc()['userName'];
            echo "" . $row["timeSent"] . "<br>   " . $userName . "<br>   " . $row["content"] . "<br> <br>";
        } else {
            echo 'alert("User name not found");';
            echo "<br>";
        }
    }
} else {
    echo "0 results";
}

/* Test add messages */
$projectName = "testProject";
$userName = "Lynn Cistulli";
$content = "Row Row Row your boat";
echo "Testing add message for projectID, userID" . "<br>";
$result = $project->getProjectIdByName($projectName);
$result2 = $user->getUserIdByUserName($userName);
if ($result->num_rows > 0 AND $result2->num_rows > 0) {
    $projectID = $result->fetch_assoc()['projectID'];
    $userID = $result2->fetch_assoc()['userID'];
    $result = $message->addMessage($content,$projectID, $userID);
    if (!$result)
    {
        echo "alert (Could not add " . $content . " to messages)" . "<br>";
    }
}else
{
    echo 'alert("User name or project name not found");';
    echo "<br>";
}

/* close the database */
$db->closeDB();