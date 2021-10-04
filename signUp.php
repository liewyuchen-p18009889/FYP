<!doctype html>
<html lang="en">
<head>
    <!--using external files-->
    <?php 
        ob_start(); //to solve errors of "Cannot modify header information - headers already sent"
        session_start();
        include 'import.html';
        include 'connectDB.php';
     ?>
    <!-- Sign Up Style CSS -->
    <link rel="stylesheet" type="text/css" href="/FYP/signUpStyle.css">

    <title>UTask | Sign Up</title>

    <!-- show sweet alert then proceed to projectList.php START -->
    <script type="text/javascript">
        function swalSignUp(){
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
    //redirect to projectList.php if already sign in
    if(isset($_SESSION['user_id']) && isset($_SESSION['user_email'])){
        header("Location: /FYP/projectList.php");
    }

    $signUpErrorsArr = array();

    if(isset($_POST['submittedSignUp'])){
        //validate function
        function validate($data){
            $data = trim($data);                //to remove whitespace and other predefined characters from both sides of a string.
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
            array_push($signUpErrorsArr, "Name is required! Please try again!");
        }else if(empty($email)){
            array_push($signUpErrorsArr, "Email is required! Please try again!");
        }else if(empty($password)){
            array_push($signUpErrorsArr, "Password is required! Please try again!");
        }else if(empty($cPassword)){
            array_push($signUpErrorsArr, "Confirm Password is required! Please try again!");
        }else if($password !== $cPassword){
            array_push($signUpErrorsArr, "The confirmation password does not match! Please try again!");
        }else if(mysqli_num_rows($runQuery1) > 0){
            array_push($signUpErrorsArr, "This email already exists! Please try again!");
        }

        //no errors
		if(count($signUpErrorsArr) == 0){
            $password = md5($password); //to calculate MD5 hash of a string for data security
            $query2 = "INSERT INTO users(user_name, user_email, user_password) VALUES('$name', '$email', '$password')";
            $runQuery2 = mysqli_query($dbc, $query2);

            if($runQuery2){  
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;

                // to fix bug from header.php
                $query3 = "SELECT * FROM users WHERE user_email='$email'";
                $runQuery3 = mysqli_query($dbc, $query3);

                if($runQuery3){
                    $row = mysqli_fetch_assoc($runQuery3); //to fetch a result row as an associative array
                    $_SESSION['user_id'] = $row['user_id'];

                    echo '<script type="text/javascript">swalSignUp();</script>';
                }                
            }else{
                array_push($signUpErrorsArr, "Unknown error occurred!");
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
                        <?php if(count($signUpErrorsArr) > 0){?>
                        <div class="form-group">
                            <?php
                                    foreach($signUpErrorsArr as $errorMsg){
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