<?php
    session_start();
    include 'connectDB.php';

    if(isset($_POST['updUsernameForm'])){
        $userID = $_POST['userID'];
        $userName = $_POST['userName'];

        $query4 = "SELECT * FROM users WHERE user_id='$userID'";
        $runQuery4 = mysqli_query($dbc, $query4);
        $row4 = mysqli_fetch_assoc($runQuery4);

        if($userName == $row4['user_name']){
            $status = 'fail3'; //nothing to update
        }else{
            $query1 = "UPDATE users SET user_name='$userName', updated_at=NOW()
                WHERE user_id='$userID'";
            $runQuery1 = mysqli_query($dbc, $query1);

            $status = 'success';
        }
    }else if(isset($_POST['updPasswordForm'])){
        $userID = $_POST['userID'];
        $userName = $_POST['userName'];
        $oldPassword = md5($_POST['oldPassword']);
        $newPassword1 = md5($_POST['newPassword1']);
        // $newPassword2 = $_POST['newPassword2'];

        $query2 = "SELECT * FROM users WHERE user_id='$userID' AND user_password='$oldPassword'";
        $runQuery2 = mysqli_query($dbc, $query2);
        $row2 = mysqli_fetch_assoc($runQuery2);

        if(mysqli_num_rows($runQuery2) > 0){
            if($newPassword1 == $row2['user_password']){
                $status = 'fail4'; //nothing to update
            }else{
                $query3 = "UPDATE users SET user_name='$userName', user_password='$newPassword1',
                    updated_at=NOW() WHERE user_id='$userID'";
                $runQuery3 = mysqli_query($dbc, $query3);

                $status = 'success';
            }
        }else{
            $status = 'fail2'; //wrong old password
        }
    }

    echo $status;die;   //status output

    mysqli_close($dbc);
?>