<?php
    include 'connectDB.php';

    if(isset($_POST['del_set'])){
        $delID = $_POST['del_id'];
    }
    echo 'hihi '.$delID.'hihi';

    $query1 = "DELETE FROM task WHERE task_id=".$delID;
    $runQuery1 = mysqli_query($dbc, $query1);
    echo $query1;

    if($runQuery1){
        $status = 'success';
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>