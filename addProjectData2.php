<?php
    session_start();
    include 'connectDB.php';

    if(isset($_POST['addProjectForm']) && !empty($_POST['addProjectTitle'])){
    
        $projectTitle = $_POST['addProjectTitle'];
        $projectCreator = $_SESSION['user_id'];
    }

    $query1 = "INSERT INTO projects (project_title, project_creator, created_at, updated_at) 
			VALUES ('$projectTitle', '$projectCreator', NOW(), NOW())";
    $runQuery1 = mysqli_query($dbc, $query1);
    $latestprojectID = mysqli_insert_id($dbc);

    if($runQuery1){
        $query2 = "INSERT INTO project_members (user_id, project_id) 
            VALUES ('$projectCreator', '$latestprojectID')";
        $runQuery2 = mysqli_query($dbc, $query2);
        
        if($runQuery2){
            $status = 'success';
        }else{
            $status = 'fail';
        }
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>