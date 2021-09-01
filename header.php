<?php
	include 'connectDB.php';
?>
<div class="container-fluid bg-info shadow" id="header">
	<div class="row justify-content-around">
		<div class="col-4">
			<a href="#"><h1 style="text-align: center; color: #feffff; margin: 20px 0;">UTask</h1></a>
		</div>
		<div class="col-4"></div>
		<div class="col-4 d-flex justify-content-center align-items-center">
			<?php if(isset($_SESSION['user_id']) && isset($_SESSION['user_email'])){ ?>
			<div class="dropdown">
				<a class="btn btn-outline-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
					data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-user"></i>&nbsp; <?php echo $_SESSION['user_name']; ?>
				</a>
				<div class="dropdown-menu shadow bg-white rounded" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="/FYP/dashboard.php" target="_blank"><i class="fab fa-elementor"
							style="color: #3AAFA9"></i>&nbsp; Dashboard</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="/FYP/logout.php"><i class="fas fa-sign-out-alt"
							style="color: #3AAFA9"></i>&nbsp; Logout</a>
				</div>
			</div>
			<?php 
				}else{ 
					header("Location: /FYP/signIn.php");
					exit();
				} 
			?>
		</div>
	</div>
</div>