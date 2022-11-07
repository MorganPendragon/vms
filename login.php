<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--BS 5-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
	<!--jQuery-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<!--BS js-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="script.js"></script>
	<link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
	<title>Log In</title>
	<style>
		* {
			box-sizing: border-box;
			font-family: 'Montserrat';
			padding: 0;
			margin: 0;
			position: relative;
		}

		.window-height {
			height: 100vh;
		}
	</style>
</head>

<body>
	<main>
		<!--background image-->
		<div class="bg-image justify-content-center align-items-center" id="login" style="background-image: url('img/bglogin.png'); height: 100vh;">
			<!--for logo-->
			<div class="container-fluid">
				<div class="row">
					<div class="d-flex col-6 justify-content-center align-items-center window-height">
						<img src="img/loginlogo.png" class="img-fluid" alt="">
					</div>
					<!--log in-->
					<div class="col-6 ">
						<div>
							<div class="container">
								<div class="d-flex container-fluid justify-content-center align-items-center window-height" style="background-color:rgb(255, 255, 255);">

									<div id="card" class="card w-75 h-50 shadow-lg p-3 mb-5 bg-body rounded-5">
										<form>
											<div class="card-body w-75 mx-auto">
												<P class="fs-1 fw-bold mt-3">Login</P>
												<div class="mb-3 my-4">
													<label class="fw-semibold" for="idNo">ID</label>
													<input type="text" class="form-control text-center" id="idNo" required>
													<div id="idFeedback"></div>
												</div>
												<div class="mb-3">
													<label class="fw-semibold" for="pwd">Password</label>
													<input type="password" id="pwd" class="form-control text-center" required>
													<div id="pwdFeedback" class="invalid-feedback"></div>
												</div>
												<p class="text-end">
													<a href="#" type="button" class="btn btn-link" style="color:#ED7E00;">Forgot password?</a>
												</p>
												<div class=" gap-2 mx-auto text-center">
													<button type="submit" class="btn" style="width:50%; border-radius:30px; background-color:rgb(16, 45, 65);color:white;">Log In</button>
												</div>
											</div>
										</form>
										<div class="d-flex justify-content-center  p-1">
											<label for="snup">Don`t have an account?
												<button type="button" id="snup" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#signup" style="color:black; font-weight:bold;">
													Sign Up
												</button>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--modal for signup-->
				</div>
				<div class="modal fade" id="signup" tabindex="-1" aria-labelledby="signup" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h1 class="modal-title fs-5 " id="signup">Registration</h1>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="row mb-3">
									<div class="col">
										<button class="btn btn-primary" data-bs-dismiss="modal" id="signUpStudent" data-show="#student" data-hide="#login">Student</button>
									</div>
									<div class="col">
										<button class="btn btn-primary" data-bs-dismiss="modal" id="signUpFaculty" data-show="#faculty" data-hide="#login">Faculty</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="student" style="display: none;">
			<!--TODO:Content-->
			<button class="btn btn-primary" name="back" data-show="#login" data-hide="#student">Back</button>
			<p class="fs-1">DAMN</p>
		</div>
		<div id="faculty" style="display: none;">
			<button class="btn btn-primary" name="back" data-show="#login" data-hide="#faculty">Back</button>
			<p class="fs-1">DAYUM</p>
		</div>
	</main>

</body>

</html>