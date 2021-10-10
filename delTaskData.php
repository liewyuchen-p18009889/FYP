<?php
    include 'connectDB.php';

    if(isset($_POST['del_set'])){
        $delID = $_POST['del_id'];
    }

    $query1 = "DELETE FROM tasks WHERE task_id=".$delID;
    $runQuery1 = mysqli_query($dbc, $query1);

    if($runQuery1){
        $status = 'success';
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>