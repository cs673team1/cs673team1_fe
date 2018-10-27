<?php 
    $table = $_POST['table'];
    $project = $_POST['project'];
    $email = $_POST['user'];
    
    $servername = 'localhost';
    $username = 'root';
    $password = 'cs673Team2';
    $dbname = 'c3poLive';

    //echo "alert('Params: '".$table.", ".$project.", ".$email."');";

    $conn = new mysqli($servername, $username, $password, $dbname); //, $dbport);
    
    // Check connection
    if ($conn->connect_errno)
    {
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

    
    if ($table == 'story')
    {
        $storyName = $_POST['name'];
        $storySize = $_POST['size'];
        $description = $_POST['desc'];
        
        if ($storySize == "small")
            $storyPoints = 1;
        else if ($storySize == "medium")
            $storyPoints = 2;
        else if (storySize == "large")
            $storyPoints = 3;
        else
            $storyPoints = "NULL";
        
        
        $sql1 = "INSERT INTO story (project, storyName, storyPoints, description, creator, owner) VALUES ";
        $sql2 = "(".$projectID.", '".$storyName."', ".$storyPoints.", '".$description."', ".$userID.", ".$userID.")";
        $sql = $sql1 . $sql2;
        
        if(!$conn->query($sql)) 
        {
            echo "SQL ERROR";
        }
                
    } else
    {
        echo "Invalid table request.";
    }

    $conn->close();
?>
