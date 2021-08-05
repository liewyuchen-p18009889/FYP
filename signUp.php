<!doctype html>
<html lang="en">

<head>
    <!--using external files-->
    <?php require('import.html') ?>
    <!-- Sign Up Style CSS -->
    <link rel="stylesheet" href="/FYP/signUpStyle.css">

    <title>UTask | Sign Up</title>
</head>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="mr-3 ml-3 mt-0 form_container">
                    <form>
                        <div class="d-flex justify-content-center">
                            <h3 class="mb-4" style="color: #3AAFA9;">Create Account</h3>
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleInputEmail1">Email address</label> -->
                            <input type="text" class="form-control" id="exampleInputName1"
                                placeholder="Name" style="background: #e6e6e6;">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small> -->
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleInputEmail1">Email address</label> -->
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Email address" style="background: #e6e6e6;">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                                else.</small> -->
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleInputPassword1">Password</label> -->
                            <input type="password" class="form-control" id="exampleInputPassword1"
                                placeholder="Password" style="background: #e6e6e6;">
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleInputPassword1">Password</label> -->
                            <input type="password" class="form-control" id="exampleInputPassword2"
                                placeholder="Confirm Password" style="background: #e6e6e6;">
                        </div>
                        <!-- <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> -->
                        <button type="submit" class="btn btn-info btn-block"
                            style="background-color: #3AAFA9; border-radius: 20px;">Sign Up</button>
                    </form>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links" style="color: #17252A;">
                        Already have an account? <a href="/FYP/signIn.php" class="ml-2" style="color: #3AAFA9;">Sign In</a>
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