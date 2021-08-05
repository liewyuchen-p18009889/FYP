<!doctype html>
<html lang="en">

<head>
    <!--using external files-->
    <?php require('import.html') ?>
    <!-- Sign In Style CSS -->
    <link rel="stylesheet" href="/FYP/signInStyle.css">

    <title>UTask | Sign In</title>
</head>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <!-- <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="https://cdn.freebiesupply.com/logos/large/2x/pinterest-circle-logo-png-transparent.png" class="brand_logo" alt="Logo">
                        <img src="https://via.placeholder.com/350x350" class="brand_logo" alt="Logo">
                    </div>
                </div> -->
                <div class="mr-3 ml-3 mt-0 form_container">
                    <!-- <form>
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="" class="form-control input_user" value="" placeholder="username">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="" class="form-control input_pass" value="" placeholder="password">
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="customControlInline">
								<label class="custom-control-label" for="customControlInline">Remember me</label>
							</div>
						</div>
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="button" name="button" class="btn login_btn">Login</button>
				   </div>
					</form> -->
                    <form>
                        <div class="d-flex justify-content-center">
                            <h3 class="mb-4" style="color: #3AAFA9;">Sign In to UTask</h3>
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
                        <!-- <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> -->
                        <button type="submit" class="btn btn-info btn-block"
                            style="background-color: #3AAFA9; border-radius: 20px;">Sign In</button>
                    </form>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links" style="color: #17252A;">
                        Don't have an account? <a href="/FYP/signUp.php" class="ml-2" style="color: #3AAFA9;">Sign Up</a>
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