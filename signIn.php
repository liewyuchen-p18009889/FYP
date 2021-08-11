<!doctype html>
<html lang="en">

<head>
    <!--using external files-->
    <?php require('import.html') ?>
    <!-- Sign In Style CSS -->
    <link rel="stylesheet" href="/FYP/signInStyle1.css">

    <title>UTask | Sign In</title>

    <!-- show sweet alert then proceed to projectList.php START -->
    <script type="text/javascript">
        function swalFunc(){
            $(function () {
                swal("Sign in successfully!", "Let's start to work on your projects!", "success")
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
    include 'connectDB.php';

    //redirect to projectList.php if already sign in
    if(isset($_SESSION['user_id']) && isset($_SESSION['user_email'])){
        header("Location: /FYP/projectList.php");
    }

    $signInErrorsArr = array();

    if(isset($_POST['submittedSignIn'])){
        //validate function
        function validate($data){
            $date = trim($data);                //to remove whitespace and other predefined characters from both sides of a string.
            $data = stripslashes($data);        //to remove backslashes
	        $data = htmlspecialchars($data);    //to convert some predefined characters to HTML entities

	        return $data;
        }

        $email = validate($_POST['signInEmail']);
        $password = validate($_POST['signInPassword']);
        $password = md5($password); //to calculate MD5 hash of a string for data security

        $query1 = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password'";
        $runQuery1 = mysqli_query($dbc, $query1);

        //to ensure form fields are filled properly
        if(empty($email)){
            array_push($signInErrorsArr, "Email is required! Please try again!");
        }else if(empty($password) || $password == "d41d8cd98f00b204e9800998ecf8427e"){
            array_push($signInErrorsArr, "Password is required! Please try again!");
        }else if(mysqli_num_rows($runQuery1) === 1){
            $row = mysqli_fetch_assoc($runQuery1); //to fetch a result row as an associative array
            if($row['user_email'] === $email && $row['user_password'] === $password){ //login ok
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['user_email'] = $row['user_email'];
                $_SESSION['user_password'] = $row['user_password'];

                echo '<script type="text/javascript">swalFunc();</script>';
            }else{
                array_push($signInErrorsArr, "Incorrect email or password! Please try again!111");
            }
        }else{
            array_push($signInErrorsArr, "Incorrect email or password! Please try again!");
        }
    }
    mysqli_close($dbc);
?>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="mr-3 ml-3 mt-0 form_container">
                    <form action="/FYP/signIn.php" method="post" id="signInForm">
                        <div class="d-flex justify-content-center">
                            <h3 class="mb-4" style="color: #3AAFA9;">Sign In to UTask</h3>
                        </div>
                        <?php if(count($signInErrorsArr) > 0){?>
                        <div class="form-group">
                            <?php
                                    foreach($signInErrorsArr as $errorMsg){
                                        echo "<div class=\"alert alert-danger pt-1 pb-1\" role=\"alert\">".$errorMsg."</div>";
                                    }
                                ?>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <!-- <label for="exampleInputEmail1">Email address</label> -->
                            <input type="email" class="form-control" name="signInEmail" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Email address" style="background: #e6e6e6;" value="<?php if(!empty($email)){echo $email;} ?>">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small> -->
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleInputPassword1">Password</label> -->
                            <input type="password" class="form-control" name="signInPassword" id="exampleInputPassword1"
                                placeholder="Password" style="background: #e6e6e6;">

                        </div>
                        <!-- <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> -->
                        <button type="submit" class="btn btn-info btn-block"
                            style="background-color: #3AAFA9; border-radius: 20px;">Sign In</button>
                        <input type="hidden" name="submittedSignIn">
                    </form>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links" style="color: #17252A;">
                        Don't have an account? <a href="/FYP/signUp.php" class="ml-2" style="color: #3AAFA9;"><b>Sign
                                Up</b></a>
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