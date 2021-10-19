<?php
    session_start();
    include 'connectDB.php';

    if(isset($_GET['id']) && isset($_GET['status'])){
        $taskID = $_GET['id'];
        $taskStatus = $_GET['status'];

        switch ($taskStatus) {
            case 'drag1':
                $taskStatus = 'To Do';
                break;
            case 'drag2':
                $taskStatus = 'In Progress';
                break;
            case 'drag3':
                $taskStatus = 'Test';
                break;
            case 'drag4':
                $taskStatus = 'Done';
                break;
        }
    }

    $query1 = "UPDATE tasks SET task_status='$taskStatus', task_updated_at=NOW()
                WHERE task_id=$taskID";
    $runQuery1 = mysqli_query($dbc, $query1);
    // echo $query1;

    if($runQuery1){
        $status = 'success';
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>