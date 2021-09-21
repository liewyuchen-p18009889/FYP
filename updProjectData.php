<?php
    session_start();
    include 'connectDB.php';

    if(isset($_POST['updProjectForm']) && isset($_POST['updateProject_id']) && !empty($_POST['updProjectTitle'])){
        $projectID = $_POST['updateProject_id'];
        $projectTitle = $_POST['updProjectTitle'];
    }
    
    $query = "UPDATE projects SET project_title='$projectTitle',
    updated_at=NOW() WHERE project_id='$projectID'";

    $runQuery = mysqli_query($dbc, $query);

    if($runQuery){
        $status = 'success';
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>