<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--BS 5-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<!--jQuery-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<!--BS js-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="script.js"></script>
	<link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
	<script src="https://kit.fontawesome.com/9dd1cea6a6.js" crossorigin="anonymous"></script>
	<title>Log In</title>
	<style>
		* {
			box-sizing: border-box;
			font-family: 'Montserrat';
			padding: 0;
			margin: 0;
			position: relative;
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
					<div class="d-flex col-6 justify-content-center align-items-center " style="height:100vh;">
						<img src="img/loginlogo.png" class="img-fluid" alt="">
					</div>
					<!--log in-->
					<div class="col-6 ">
						<div>
							<div class="container">
								<div class="d-inline container-fluid justify-content-center align-items-center " style="background-color:rgb(255, 255, 255); height:100vh;">
									<p class="fs-1 mb-5 mt-5 ms-4 pt-5" style="font-weight:900;">Welcome</p>
									<div class="d-flex justify-content-center">
										<div id="card" class="card w-75 h-50 shadow-lg p-3 mb-5 bg-body rounded-5">
											<form method="POST" id="login">
												<div class="card-body w-75 mx-auto">
													<p class="fs-1 fw-bold mt-3">Login</p>
													<div name="loginFeedback"></div>
													<div class="mb-3 my-4">
														<label class="fw-semibold" for="idNo">ID</label>
														<input type="text" class="form-control text-center" name="id[0]" required>
													</div>
													<div class="mb-3">
														<label class="fw-semibold" for="pwd">Password</label>
														<input type="password" name="password[0]" class="form-control text-center" required>
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
												<label for="signUp">Don`t have an account?
													<button type="button" id="signUp" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#signup" style="color:black; font-weight:bold;">
														Sign Up
													</button>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!--modal for signup-->
				<div class="modal fade" id="signup" tabindex="-1" aria-labelledby="signup" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="d-flex justify-content-end">
								<p class="fw-bold fs-1 me-5 mt-3" id="signup">Sign Up As?</p>
								<button type="button" class="btn-close ms-5 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="d-grid gap-2 row mb-3">
									<div class="d-flex justify-content-center my-2">
										<button class="btn rounded-pill w-50 mh-100	fs-4" style="background-color:rgb(16, 45, 65); color:white" data-bs-dismiss="modal" id="signUpStudent" data-show="#student" data-hide="#login">Student</button>
									</div>
									<div class="d-flex justify-content-center my-2">
										<button class="btn rounded-pill w-50 mh-100 fs-4" style="background-color:rgb(237, 126, 0); color:white" data-bs-dismiss="modal" id="signUpFaculty" data-show="#faculty" data-hide="#login">Faculty</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--student signup-->
		<div id="student" style="display: none;">
			<!--background image-->
			<div class="bg-image justify-content-center align-items-center" id="login" style="background-image: url('img/bglogin.png'); height: 100vh;">
				<!--for logo-->
				<div class="container-fluid">
					<div class="row">
						<div class="d-flex col-6 justify-content-center align-items-center " style="height:100vh;">
							<img src="img/loginlogo.png" class="img-fluid" alt="">
						</div>
						<!--student sign up-->
						<div class="col-6 ">
							<div>
								<div class="container">
									<div class="container-fluid justify-content-center align-items-center " style="background-color:rgb(255, 255, 255); height:100vh;">
										<button class="btn btn-link fs-4 fw-bold mb-2 mt-5 ms-2 pt-5" style="color:black;" name="back" data-show="#login" data-hide="#student"><i class="fa-solid fa-angle-left"></i>Back</button>
										<div class="d-flex ms-5 ps-2">
											<div class=" mb-5">
												<form>
													<p class="fs-1" style="font-weight:900;">Sign-Up</p>
													<p class="fs-5 fw-semibold">Create your <span class="text-warning">Student</span><br>account </p>
													<div class="row mb-3 my-4">
														<div class="col-6">
															<label class="fw-semibold">First
																Name</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
														<div class="col-6">
															<label class="fw-semibold">Email
																Address</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
													</div>
													<div class="row mb-3 my-4">
														<div class="col-6">
															<label class="fw-semibold">Middle
																Initial</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
														<div class="col-6">
															<label class="fw-semibold">Age</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
													</div>
													<div class="row mb-3 my-4">
														<div class="col-6">
															<label class="fw-semibold">Surname</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
														<div class="col-6">
															<label class="fw-semibold">Birthday</label>
															<input type="date" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
													</div>
													<div class="row mb-3 my-4">
														<div class="col-6">
															<label class="fw-semibold">Suffix</label>
															<input type="text" class="form-control">
															<div id="idFeedback"></div>
															<label class="fw-semibold">Year
																Level</label>
															<select class="form-select" required>
																<option value="" hidden></option>
																<option value="Grade 7">Grade 7</option>
																<option value="Grade 8">Grade 8</option>
																<option value="Grade 9">Grade 9</option>
																<option value="Grade 10">Grade 10</option>
																<option value="Grade 11">Grade 11</option>
																<option value="Grade 12">Grade 12</option>
															</select>
															<div id="idFeedback"></div>
														</div>
														<div class="col-6">
															<label class="fw-semibold">Student ID
																Number</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
													</div>
												</form>
												<div class="gap-2 mx-auto text-center">
													<div class=" gap-2 mx-auto text-center">
														<button type="submit" class="btn" style="width:50%; border-radius:30px; background-color:rgb(237, 126, 0);color:white;">Sign-up</button>
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
			</div>
		</div>
		<!--Faculty sign up-->
		<div id="faculty" style="display: none;">
			<div class="bg-image justify-content-center align-items-center" id="login" style="background-image: url('img/bglogin.png'); height: 100vh;">
				<!--for logo-->
				<div class="container-fluid">
					<div class="row">
						<div class="d-flex col-6 justify-content-center align-items-center " style="height:100vh;">
							<img src="img/loginlogo.png" class="img-fluid" alt="">
						</div>
						<!--Faculty sign up-->
						<div class="col-6 ">
							<div>
								<div class="container">
									<div class="container-fluid justify-content-center align-items-center " style="background-color:rgb(255, 255, 255); height:100vh;">
										<button class="btn btn-link fs-4 fw-bold mb-2 mt-5 ms-2 pt-5" style="color:black;" name="back" data-show="#login" data-hide="#student"><i class="fa-solid fa-angle-left"></i>Back</button>
										<div class="d-flex ms-5 ps-2">
											<div class=" mb-5">
												<form>
													<p class="fs-1" style="font-weight:900;">Sign-Up</p>
													<p class="fs-5 fw-semibold">Create your <span class="text-warning">Faculty</span><br>account </p>
													<div class="row mb-3 my-4">
														<div class="col-6">
															<label class="fw-semibold">First
																Name</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
														<div class="col-6">
															<label class="fw-semibold">Email
																Address</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
													</div>
													<div class="row mb-3 my-4">
														<div class="col-6">
															<label class="fw-semibold">Middle
																Initial</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
														<div class="col-6">
															<label class="fw-semibold">Age</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
													</div>
													<div class="row mb-3 my-4">
														<div class="col-6">
															<label class="fw-semibold">Surname</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
														<div class="col-6">
															<label class="fw-semibold">Birthday</label>
															<input type="date" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
													</div>
													<div class="row mb-3 my-4">
														<div class="col-6">
															<label class="fw-semibold">Suffix</label>
															<input type="text" class="form-control">
															<div id="idFeedback"></div>
															<label class="fw-semibold">Year
																Level</label>
															<select class="form-select" required>
																<option value="" hidden></option>
																<option value="Grade 7">Grade 7</option>
																<option value="Grade 8">Grade 8</option>
																<option value="Grade 9">Grade 9</option>
																<option value="Grade 10">Grade 10</option>
																<option value="Grade 11">Grade 11</option>
																<option value="Grade 12">Grade 12</option>
															</select>
															<div id="idFeedback"></div>
														</div>
														<div class="col-6">
															<label class="fw-semibold">Faculty ID
																Number</label>
															<input type="text" class="form-control" required>
															<div id="idFeedback"></div>
														</div>
													</div>
												</form>
												<div class="gap-2 mx-auto text-center">
													<div class=" gap-2 mx-auto text-center">
														<button type="submit" class="btn" style="width:50%; border-radius:30px; background-color:rgb(237, 126, 0);color:white;">Sign-up</button>
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
			</div>
		</div>


	</main>

</body>

</html>