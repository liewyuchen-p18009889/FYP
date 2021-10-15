<?php
    include 'connectDB.php';

    if(isset($_POST['delMember_set'])){
        $projectID = $_POST['project_id'];
        $memberID = $_POST['member_id'];
    }

    $query1 = "DELETE FROM project_members WHERE projectMember_id=$memberID";
    $runQuery1 = mysqli_query($dbc, $query1);

    if($runQuery1){
        $status = 'success';
    }else{
        $status = 'fail';
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>