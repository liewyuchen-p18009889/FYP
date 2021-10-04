<?php
    session_start();
    include 'connectDB.php';

    if(isset($_POST['addTaskForm']) && !empty($_POST['addTaskTitle']) && !empty($_POST['addTaskStart'])
    && !empty($_POST['addTaskEnd']) && !empty($_POST['addTaskAsignee']) && !empty($_POST['addTaskStatus'])
    && !empty($_POST['addTaskDescrp'])){
    
        $projectID = $_POST['projectID'];
        $taskTitle = $_POST['addTaskTitle'];
        $taskStart = $_POST['addTaskStart'];
        $taskEnd = $_POST['addTaskEnd'];
        $taskStatus = $_POST['addTaskStatus'];
        $taskAsignee = $_POST['addTaskAsignee'];
        $taskDescrp = $_POST['addTaskDescrp'];
    }

    $query1 = "INSERT INTO tasks (task_title, task_start, task_end, task_status, task_asignee, 
                task_description, task_project, created_at, updated_at) 
			    VALUES ('$taskTitle', '$taskStart', '$taskEnd', '$taskStatus', '$taskAsignee',
                '$taskDescrp', '$projectID', NOW(), NOW())";
    $runQuery1 = mysqli_query($dbc, $query1);

    if($runQuery1){
        $status = 'success';
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>