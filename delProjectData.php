<?php
    include 'connectDB.php';

    if(isset($_POST['del_set'])){
        $delID = $_POST['del_id'];
        echo "After ajax: ".$delID;
    }

    $query = "DELETE FROM projects WHERE project_id=".$delID;
    $runQuery = mysqli_query($dbc, $query);

    mysqli_close($dbc);
?>