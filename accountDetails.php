<!doctype html>
<html lang="en">

<head>
    <!--using external files-->
    <?php 
        ob_start(); //to solve errors of "Cannot modify header information - headers already sent"
        session_start();
        include 'import.html';
     ?>

    <!-- Side Menu Bar Style CSS -->
    <style>
        .swal-text {
            text-align: center;
        }

        .swal-footer {
            text-align: center;
        }
    </style>

    <title>UTask | My Account</title>

    <script type="text/javascript">
        function enableUpdPassword(){
            $("#show_oldPassword").show();
            $("#show_newPassword1").show();
            $("#show_newPassword2").show();
            $("#show_btnUpdPassword").show();
            $("#hide_btnUpdUsername").hide();
        }
        // update username only START
        function submitUpdUsername(){
            var userID = $('#userID').val();
            var userName = $('#inputUsername').val();

            if(userName.trim() == ''){
                $('.userNameMsg').text('Username is required!');
                $('#inputUsername').focus();
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: "/FYP/updUserData.php",
                    data: "updUsernameForm=1&userID=" + userID + "&userName=" + userName,
                    success: function (response) {
                        console.log(response);
                        if (response == 'success') {
                            swal({
                                title: "Username updated successfully!",
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        } else if (response == 'fail3'){
                            $(function () {
                                swal("Nothing to update!", "Username remains the same!", "warning");
                            });
                        } else {
                            $(function () {
                                swal("Something went wrong!", "", "warning");
                            });
                        }
                    }
                });
            }
        }
        // update username only END
        // update username & paswword START
        function submitUpdPassword(){
            var inputErrorArr = []; // to store error numbers of input field
            var userID = $('#userID').val();
            var userName = $('#inputUsername').val();
            var oldPassword = $('#inputOldPassword').val();
            var newPassword1 = $('#inputNewPassword1').val();
            var newPassword2 = $('#inputNewPassword2').val();

            if(userName.trim() == ''){
                $('.userNameMsg').text('Username is required!');
                $('#inputUsername').focus();
                inputErrorArr.push(1);
            }
            if(oldPassword.trim() == ''){
                $('.oldPasswordMsg').text('Old password is required!');
                $('#inputOldPassword').focus();
                inputErrorArr.push(1);
            }
            if(newPassword1.trim() == ''){
                $('.newPasswordMsg1').text('New password is required!');
                $('#inputNewPassword1').focus();
                inputErrorArr.push(1);
            }
            else if(newPassword1.trim().length < 8){
                $('.newPasswordMsg1').text('Password must be at least 8 characters!');
                $('#inputNewPassword1').focus();
                inputErrorArr.push(1);
            }
            if(newPassword2.trim() == ''){
                $('.newPasswordMsg2').text('Confirm new password is required!');
                $('#inputNewPassword2').focus();
                inputErrorArr.push(1);
            }
            if(newPassword1.trim() != newPassword2.trim()){
                $('.newPasswordMsg2').text('The new password does not match!');
                $('#inputNewPassword2').focus();
                inputErrorArr.push(1);
            }
            if(inputErrorArr.length == 0){
                $.ajax({
                    type: "POST",
                    url: "/FYP/updUserData.php",
                    data: {
                        "updPasswordForm": '1',
                        "userID": userID,
                        "userName": userName,
                        "oldPassword": oldPassword,
                        "newPassword1": newPassword1,
                        "newPassword2": newPassword2
                    },
                    success: function (response) {
                        console.log("change password: " + response);
                        if (response == 'success') {
                            swal({
                                title: "Password updated successfully!",
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        } else if (response == 'fail2') {
                            $(function () {
                                swal("Incorrect password!", "", "warning");
                            });
                        } else if (response == 'fail4') {
                            $(function () {
                                swal("Nothing to update!", "Password remains the same!", "warning");
                            });
                        } else{
                            $(function () {
                                swal("Something went wrong!", "", "warning");
                            });
                        }
                    }
                });
            }
        }
        // update username & paswword END
    </script>
</head>

<body class="bg-light">
    <?php include 'header.php'; 
        // check if the user can only access to own account details START
        if($_SESSION['user_id'] != $_GET['userID']){
            echo '<script language="javascript">
                    alert("Invalid URL!");
                    window.location.href="/FYP/projectList.php";
                    </script>';
                    
        }
        // check if the user can only access to own account details END
    ?>
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-md-6 col-xs-12 p-0">
                <h3 class="text-info"><a href="/FYP/projectList.php" title="Back to My Projects"><i
                            class="fas fa-arrow-left text-info"></i></a> My Account</h3>
            </div>
            <div class="col-md-6 col-xs-12 p-0 d-flex justify-content-end">
                <button class="btn btn-info" type="button" onclick="enableUpdPassword()"><i class="fas fa-user-lock"
                        style="font-size: 20px;"></i>&nbsp;Change Password
                </button>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="card shadow p-4 mb-5 ml-3 mr-3 bg-white rounded">
            <?php
            $query1 = "SELECT * FROM users WHERE user_id={$_GET['userID']}";
            $runQuery1 = mysqli_query($dbc, $query1);

            if($runQuery1){
                foreach($runQuery1 as $row1){
                    ?>
            <form>
                <input type="hidden" id="userID" value="<?php echo $_GET['userID']; ?>">
                <div class="form-group row mt-3">
                    <label for="inputUsername" class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputUsername" placeholder="Username" value="<?php echo $row1['user_name']; ?>">
                        <p class="m-0 p-2 text-danger userNameMsg"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Email" value="<?php echo $row1['user_email']; ?>" disabled>
                        <p class="m-0 p-2 text-danger"></p>
                    </div>
                </div>
                <div class="form-group row" id="show_oldPassword" style="display: none;">
                    <label for="inputOldPassword" class="col-sm-2 col-form-label">Old Password <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputOldPassword" placeholder="Old Password">
                        <p class="m-0 p-2 text-danger oldPasswordMsg"></p>
                    </div>
                </div>
                <div class="form-group row" id="show_newPassword1" style="display: none;">
                    <label for="inputNewPassword1" class="col-sm-2 col-form-label">New Password <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputNewPassword1" placeholder="New Password">
                        <p class="m-0 p-2 text-danger newPasswordMsg1"></p>
                    </div>
                </div>
                <div class="form-group row" id="show_newPassword2" style="display: none;">
                    <label for="inputNewPassword2" class="col-sm-2 col-form-label">Confirm New Password <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputNewPassword2" placeholder="Confirm New Password">
                        <p class="m-0 p-2 text-danger newPasswordMsg2"></p>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-1" id="" onclick="window.location.reload();">Cancel</button>
                        <button type="button" class="btn btn-info ml-1" id="hide_btnUpdUsername"  onclick="submitUpdUsername()">Save</button>
                        <button type="button" class="btn btn-info ml-1" id="show_btnUpdPassword" style="display: none;" onclick="submitUpdPassword()">Save</button>
                    </div>
                </div>
            </form>
            <?php
                }
            }
        ?>
        </div>
    </div>
    <?php include 'footer.html'; ?>
</body>

</html>