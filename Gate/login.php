<?php

require('../config.php');

if (isset($_POST['Submit'])) {
	if (registrasi($_POST) > 0) {
		echo "<script>
				alert('Akun Berhasil Dibuat');
			</script>";
	} else {
		echo "<script>
				alert('Akun Gagal Dibuat');
			</script>";
	}
}

if (isset($_POST['masuk'])) {
	if (login($_POST) > 0) {
	} else {
		echo "<script>
				alert('Username atau Password Salah');
			</script>";
	}
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>BetaGlowing Login Page</title>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="bg.css">

</head>

<body>
	<div class="wave"></div>
	<div class="wave"></div>
	<div class="wave"></div>
	<!-- partial:index.partial.html -->
	<div class="section">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
						<input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
						<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Log In</h4>
											<form action="" method="post">
												<div class="form-group">
													<input type="text" name="username" class="form-style" placeholder="Your Username" id="username" autocomplete="off">
													<i class="input-icon uil uil-user"></i>
												</div>
												<div class="form-group mt-2">
													<input type="password" name="pass" class="form-style" placeholder="Your Password" id="pass" autocomplete="off">
													<i class="input-icon uil uil-lock-alt"></i>
												</div>
												<button type="submit" name="masuk" class="btn mt-4">Login</button>
											</form>
										</div>
									</div>
								</div>
								<div class="card-back">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Sign Up</h4>
											<form action="" method="post">
												<div class="form-group">
													<input type="email" name="email" class="form-style" placeholder="Your Email" id="email" autocomplete="off" required>
													<i class="input-icon uil uil-at"></i>
												</div>
												<div class="form-group  mt-2">
													<input type="text" name="username" class="form-style" placeholder=" Your UserName" id="username" autocomplete="off" required>
													<i class="input-icon uil uil-user"></i>
												</div>
												<div class="form-group mt-2">
													<input type="password" name="pass" class="form-style" placeholder="Your Password" id="pass" autocomplete="off" required>
													<i class="input-icon uil uil-lock-alt"></i>
												</div>
												<div class="form-group mt-2">
													<input type="password" name="pass2" class="form-style" placeholder="confirm password" id="pass" autocomplete="off" required>
													<i class="input-icon uil uil-lock-alt"></i>
												</div>

												<button type="Submit" name="Submit" class="btn mt-4">daftar</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- partial -->
</body>

</html>