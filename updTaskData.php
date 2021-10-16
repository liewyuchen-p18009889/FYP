<?php
    session_start();
    include 'connectDB.php';

    if(isset($_POST['updTaskForm']) && isset($_POST['projectID']) && isset($_POST['taskID'])){
        $projectID = $_POST['projectID'];
        $taskID = $_POST['taskID'];
        $taskTitle = $_POST['viewTaskTitle'];
        $taskStart = $_POST['viewTaskStart'];
        $taskEnd = $_POST['viewTaskEnd'];
        $taskAsignee = $_POST['viewTaskAsignee'];
        $taskStatus = $_POST['viewTaskStatus'];
        $taskDescrp = $_POST['viewTaskDescrp'];
        $time = 'T23:59';
    }
    
    $query = "UPDATE tasks SET task_title='$taskTitle', task_start='$taskStart',
                task_end='$taskEnd$time', task_asignee='$taskAsignee',
                task_status='$taskStatus', task_description='$taskDescrp',
                updated_at=NOW() 
                WHERE task_project='$projectID' AND task_id='$taskID'";

    $runQuery = mysqli_query($dbc, $query);

    if($runQuery){
        $status = 'success';
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>