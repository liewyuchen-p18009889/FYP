<?php
    include 'connectDB.php';

    if(isset($_POST['del_set'])){
        $delID = $_POST['del_id'];
    }

    $query1 = "DELETE FROM project_members WHERE project_id=".$delID;
    $runQuery1 = mysqli_query($dbc, $query1);
    echo $query1;

    if($runQuery1){
        $query2 = "DELETE FROM projects WHERE project_id=".$delID;
        $runQuery2 = mysqli_query($dbc, $query2);
        echo $query2;

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