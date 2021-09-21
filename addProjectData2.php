<?php
    session_start();
    include 'connectDB.php';

    if(isset($_POST['addProjectForm']) && !empty($_POST['addProjectTitle'])){
    
        $projectTitle = $_POST['addProjectTitle'];
        $projectManager = $_SESSION['user_id'];
    }

    $query = "INSERT INTO projects (project_title, user_id, created_at, updated_at) 
			VALUES ('$projectTitle', '$projectManager', NOW(), NOW())";
    $runQuery = mysqli_query($dbc, $query);

    if($runQuery){
        $status = 'success';
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>