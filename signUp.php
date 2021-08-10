<!doctype html>
<html lang="en">
<head>
    <!--using external files-->
    <?php require('import.html') ?>
    <!-- Sign Up Style CSS -->
    <link rel="stylesheet" type="text/css" href="/FYP/signUpStyle.css">

    <title>UTask | Sign Up</title>

    <!-- show sweet alert then proceed to projectList.php START -->
    <script type="text/javascript">
        function swalFunc(){
            $(function () {
                swal("Account created successfully!", "Let's start to work on your projects!", "success")
                .then(function () {
                    window.location = "/FYP/projectList.php";
                });
            });
        }
    </script>
    <!-- show sweet alert then proceed to projectList.php END -->
</head>

<?php
    session_start();
    // require('import.html');
    include 'connectDB.php';

    $errorsArr = array();

    if(isset($_POST['submittedSignUp'])){
        //validate function
        function validate($data){
            $date = trim($data);                //to remove whitespace and other predefined characters from both sides of a string.
            $data = stripslashes($data);        //to remove backslashes
	        $data = htmlspecialchars($data);    //to convert some predefined characters to HTML entities

	        return $data;
        }
        
        $name = validate($_POST['signUpName']);
        $email = validate($_POST['signUpEmail']);
        $password = validate($_POST['signUpPassword']);
        $cPassword = validate($_POST['signUpConfirmPassword']);

        $query1 = "SELECT * FROM users WHERE user_email='$email'";
        $runQuery1 = mysqli_query($dbc, $query1);
        
        //to ensure form fields are filled properly
        if(empty($name)){
            array_push($errorsArr, "Name is required! Please try again!");
        }else if(empty($email)){
            array_push($errorsArr, "Email is required! Please try again!");
        }else if(empty($password)){
            array_push($errorsArr, "Password is required! Please try again!");
        }else if(empty($cPassword)){
            array_push($errorsArr, "Confirm Password is required! Please try again!");
        }else if($password !== $cPassword){
            array_push($errorsArr, "The confirmation password does not match! Please try again!");
        }else if(mysqli_num_rows($runQuery1) > 0){
            array_push($errorsArr, "The email already exists! Please try again!");
        }

        //no errors
		if(count($errorsArr) == 0){
            $password = md5($password); //to calculate MD5 hash of a string for data security
            $query2 = "INSERT INTO users(user_name, user_email, user_password) VALUES('$name', '$email', '$password')";
            $runQuery2 = mysqli_query($dbc, $query2);

            if($runQuery2){  
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in!";
                
                echo '<script type="text/javascript">swalFunc();</script>';
                // header('Location: /FYP/projectList.php');
            }else{
                array_push($errorsArr, "Unknown error occurred!");
            }              
		}
    }
    mysqli_close($dbc);
?>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="mr-3 ml-3 mt-0 form_container">
                    <form action="/FYP/signUp.php" method="post" id="signUpForm">
                        <div class="d-flex justify-content-center">
                            <h3 class="mb-4" style="color: #3AAFA9;">Create Account</h3>
                        </div>
                        <?php if(count($errorsArr) > 0){?>
                        <div class="form-group">
                            <?php
                                    foreach($errorsArr as $errorMsg){
                                        echo "<div class=\"alert alert-danger pt-1 pb-1\" role=\"alert\">".$errorMsg."</div>";
                                    }
                                ?>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <!-- <label for="exampleInputEmail1">Email address</label> -->
                            <input type="text" class="form-control" name="signUpName" id="exampleInputName1"
                                placeholder="Name" style="background: #e6e6e6;"
                                value="<?php if(!empty($name)){echo $name;} ?>">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small> -->
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleInputEmail1">Email address</label> -->
                            <input type="email" class="form-control" name="signUpEmail" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Email address" style="background: #e6e6e6;"
                                value="<?php if(!empty($email)){echo $email;} ?>">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small> -->
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleInputPassword1">Password</label> -->
                            <input type="password" class="form-control" name="signUpPassword" id="exampleInputPassword1"
                                placeholder="Password" style="background: #e6e6e6;">
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleInputPassword1">Password</label> -->
                            <input type="password" class="form-control" name="signUpConfirmPassword"
                                id="exampleInputPassword2" placeholder="Confirm Password" style="background: #e6e6e6;">
                        </div>
                        <button type="submit" class="btn btn-info btn-block"
                            style="background-color: #3AAFA9; border-radius: 20px;">Sign Up</button>
                        <input type="hidden" name="submittedSignUp">
                    </form>
                </div>
                <div class="mt-4">
                    <div class="d-flex justify-content-center links" style="color: #17252A;">
                        Already have an account?
                        <a href="/FYP/signIn.php" class="ml-2" style="color: #3AAFA9;"><b>Sign In</b></a>
                    </div>
                    <!-- <div class="d-flex justify-content-center links">
                        <a href="#" style="color: #3AAFA9;">Forgot your password?</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>