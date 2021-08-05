<div class="container-fluid" style="background: #1f52a3;" id="header">
	<div class="row">
		<div class="col-2"></div>
		<div class="col-8">
			<a href="/205CDE/Assignment/home.php"><h1 style="text-align: center; color: #e6e8eb; margin: 20px 0;">U Chen Daily</h1></a>
		</div>
		<div class="col-2 d-flex justify-content-center align-items-center">
			<?php if(isset($_SESSION['username'])){ ?>
				<div class="dropdown">
					<a class="btn btn-outline-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user"></i>
					</a>
					<div class="dropdown-menu shadow bg-white rounded" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item" href="/205CDE/Assignment/manageNews.php" target="_blank"><i class="fas fa-user-cog" style="color: #1f52a3"></i>&nbsp;Manage News</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="/205CDE/Assignment/home.php?logout='1'"><i class="fas fa-sign-out-alt" style="color: #1f52a3"></i>&nbsp;Logout</a>
					</div>
				</div>
				<?php }else{ 
				?>
				<button type="button" class="btn btn-outline-light" data-toggle="modal" data-target="#loginFormModal">LOGIN</button>
			<?php } ?>
			<!--<a href="/205CDE/Assignment/manageNews.php" target="_blank" class="btn btn-outline-light">LOGIN</a>-->
		</div>
	</div>
</div>