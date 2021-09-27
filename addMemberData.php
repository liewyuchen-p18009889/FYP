<?php
    session_start();
    include 'connectDB.php';

    if(isset($_POST['addMemberForm']) && !empty($_POST['addMemberEmail']) && !empty($_POST['projectID'])){
    
        $memberEmail = $_POST['addMemberEmail'];
        $projectID = $_POST['projectID'];
        
        $currentUser = $_SESSION['user_email'];
    }

    $query1 = "SELECT * FROM users WHERE user_email='$memberEmail'";
    $runQuery1 = mysqli_query($dbc, $query1);

    if($runQuery1){
        if(mysqli_num_rows($runQuery1) == 0){ //check if the user exists
            $status = 'fail1';
        }else{
            foreach($runQuery1 as $row1){
                $userID = $row1['user_id'];
            }

            $query2 = "SELECT * FROM project_members WHERE user_id='$userID' AND project_id='$projectID'";
            $runQuery2 = mysqli_query($dbc, $query2);

            if($runQuery2){
                if(mysqli_num_rows($runQuery2) > 0){ //check if the user is already a member
                    $status = 'fail2';
                }else{
                    $query3 = "INSERT INTO project_members (user_id, project_id, invited_at)
                    VALUES ('$userID','$projectID', NOW())";
                    $runQuery3 = mysqli_query($dbc, $query3);
            
                    if($runQuery3){
                        $status = 'success';
                    }
                }
            }       
        }
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>