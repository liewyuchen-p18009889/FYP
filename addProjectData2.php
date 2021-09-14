<?php
    session_start();
    include 'connectDB.php';

    if(isset($_POST['addProjectForm']) && !empty($_POST['txtProjectTitle'])){
    
        $projectTitle = $_POST['txtProjectTitle'];
        $projectManager = $_SESSION['user_id'];
    }

    $query = "INSERT INTO projects (project_title, user_id, project_datetime) 
			VALUES ('$projectTitle', '$projectManager', NOW())";
    $runQuery = mysqli_query($dbc, $query);

    if($runQuery){
        $status = 'success';
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close();
?>