


<?php 
    $table = $_GET['t'];
    $email = $_GET['u'];
    $project = $_GET['p'];

    $servername = 'localhost';
    $username = 'root';
    $password = 'cs673Team2';
    $dbname = 'c3poLive';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); //, $dbport);

    
    // Check connection
    if ($conn->connect_errno) {
        echo $conn->connect_error;
        exit();
    } 

    // Get project ID - replace with passing of project ID from requester
    $sql = "SELECT projectID FROM project WHERE projectName='".$project."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        $projectID = $result->fetch_assoc()['projectID'];
    } else 
    {
        echo 'alert("Project not found: '.$project.'");';
        exit();
    }
    
    // Get project ID
    $sql = "SELECT userID FROM user WHERE email='".$email."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        $userID = $result->fetch_assoc()['userID'];
    }else 
    {
        echo 'alert("User not found");';
        exit();
    }

    if ($table == 'project')
    {
        $sql1 = 'SELECT project.projectName FROM user, project, projectTeamMembers ';
        $sql2 = 'WHERE user.userID=projectTeamMembers.user AND project.projectID=projectTeamMembers.project ';
        $sql3 = 'AND user.email="' . $email . '"';
        $sql = $sql1 . $sql2 . $sql3;
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) 
        {
            echo "<table>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['projectName'] . "</td></tr>";
            }
            echo "</table>";
        
        } else
        {
            echo "<p>You don't have any projects.</p>";
        }
        
    } else if($table == 'bug')
    {
        //echo "<p>Bugs go here</p>";
        
        $sql1 = 'SELECT bug.bugName AS bugName, user.firstName AS fName, user.lastName AS lName FROM user, project, projectTeamMembers, bug ';
        $sql2 = 'WHERE bug.project=projectTeamMembers.project AND user.userID = projectTeamMembers.user ';
        $sql3 = 'AND project.projectID = projectTeamMembers.project AND project.projectName="' . $project . '" ';
        $sql4 = 'AND user.email="' . $email . '"';
        $sql = $sql1 . $sql2 . $sql3 . $sql4;
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) 
        {
            echo "<table>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['bugName'] . "</td>";
                echo "<td>" . $row['fName'] . ' ' . $row['lName'];
                echo "</tr>";
            }
            echo "</table>";
        
        } else
        {
            echo "<p>You don't have any bugs.</p>";
        }
        
    } else if($table == 'story')
    {
        //echo "<p>Bugs go here</p>";
        
        $sql1 = 'SELECT storyName, storyPoints, description FROM story WHERE ';
        $sql2 = 'project='.$projectID;
        
        $sql = $sql1 . $sql2;
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) 
        {
            if ($row['storyName'] == 1)
            {
                $storySize = "Small";
            } else if ($row['storyName'] == 2)
            {
                $storySize = "Medium";
            } else if ($row['storyName'] == 3)
            {
                $storySize = "Large";
            } else
            {
                $storySize = "Not Defined";
            }
                
    
            echo "<table>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>Story Name</td>";
                echo "<td>" . $row['storyName'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Story Size</td>";
                echo "<td>".$storySize."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Description</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        
        } else
        {
            echo "<p>You don't have any stories.</p>";
        }
        
    } else if($table == 'chat')
    {
        echo "<p>Chat goes here</p>";
        
    } else
    {
        echo "<p>Invalid table request.</p>";
    }

    $conn->close();

