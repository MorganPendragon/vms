<!DOCTYPE html>
<html lang="en">
<!--TODO: Sign up-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Account</title>
	<link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<!--bootstrap js lib-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
	<!--jQuery-->
	<script src="./node_modules/jquery/dist/jquery.js"></script>
	<!--Date Picker-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
	<script src="script.js"></script>
	<script>
		$(function() {
			$('input[type!="file"], select').attr('disabled', 'disabled');
			
			$('input[type="file"]').on('change', function() {
				//get filename universal
				$('#filename').text($(this).val().split('\\').pop().split('/').pop());
			});

			$('input[type="email"]:last').val($('input[type="email"]:first').val());
		});
	</script>
</head>
<style>
	* {
		padding: 0;
		margin: 0;
		font-family: 'Montserrat';
	}

	.nav-pills {
		--bs-nav-pills-link-active-bg: rgb(14, 32, 45);
	}

	.button {
		padding: 4px 80px;
	}

	input[type="file"] {
		display: none;
	}

	.window-height {
		position: fixed;
	}

	.logout {
		margin-top: 450px;
		margin-left: 110px;
		font-size: 24px;
	}
</style>

<body>

	<main>
		<div class="row">
			<!--sidebar-->
			<div class="container-fluid window-height" aria-orientation="vertical">
				<div class="d-flex">
					<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0" style="background-color:#022e43;font-size:18px;">
						<img src="img\logo.png" class="img-fluid" alt="...">
						<div class="d-flex flex-column align-items-center align-items-sm-center px-3 pt-1" style="height:100vh;">
							<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="sidebar">
								<li class="nav-item active">
									<a href="#account" class="nav-link active" data-bs-toggle="tab" style="color:rgb(232, 177, 62);" data-show="#account" data-hide="#settings"><i class="bi bi-person-fill"></i>&nbsp;&nbsp;Account Information</a>
								</li>
								<li class="nav-item">
									<a href="#settings" class="nav-link" data-bs-toggle="tab" style="color:rgb(232, 177, 62);" data-show="#settings" data-hide="#account"><i class="bi bi-gear-fill"></i>&nbsp;&nbsp;Settings</a>
								</li>
								<li class="nav-item ">
									<a href="#logout" class="logout nav-link" data-bs-toggle="modal" style="color:rgb(232, 177, 62);"><i class="bi bi-box-arrow-left"></i>&nbsp;&nbsp;Logout</a>
								</li>
							</ul>

						</div>
					</div>
				</div>
			</div>

			<!--content-->
			<div class="container-fluid position-absolute col-8" style="margin-left:25%;">
				<div id="account">
					<div class="d-flex">
						<span class="fs-1" style="font-weight:900;">Account Information</span>
						<div class=" gap-2" style="margin-left:20%;">
							<button class="btn button rounded-pill mt-2 fs-5" style="background-color:rgb(237, 126, 0); color:white; display:none;" id="save" data-hide="#save, #cancel" data-show="#edit" type="button">Save</button>
							<button class="btn button rounded-pill mt-2 fs-5" style="background-color:rgb(237, 126, 0); color:white; display:none;" id="cancel" data-hide="#save, #cancel" data-show="#edit" type="button">cancel</button>
							<button class="btn button rounded-pill mt-2 fs-5" style="background-color:rgb(16, 45, 65); color:white;" id="edit" data-hide="#edit" data-show="#save, #cancel" type="button">Edit</button>
						</div>
					</div>
					<div>
						<div class="row mb-3">
						</div>
						<?php
						include('conn.php');
						$conn = new connection();
						$brand = $conn->display('vacbrand');
						$genders = array('Male', 'Female');
						$id = $_GET['id'];
						if (preg_match("/^[0-9]{1,2}-[0-9]{6,6}$/", $_GET['id']) == 1) {
							$info = $conn->display('*', 'student INNER JOIN vaccinestatus ON student.id = vaccinestatus.id', "student.id='$id'");
							$name = explode(':', $info[0]['name']);
						?>
							<!--student-->
							<form id="accountInfo" data-validation="student" data-action="update">
								<div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">First Name</span>
											<input type="text" name="fname[]" class="form-control" value="<?php echo $name[0] ?>" autocomplete="off" required>
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Middle Name</span>
											<input type="text" name="mname[]" class="form-control" value="<?php echo $name[1] ?>" autocomplete="off" required>
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Last Name</span>
											<input type="text" name="lname[]" class="form-control" value="<?php echo $name[2] ?>" autocomplete="off" required>
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Year Level</span>
											<select class="form-select" name="yearLevel" required>
												<option hidden value="">---</option>
												<?php for ($i = 7; $i < 13; $i++) {
													$value = 'Grade ' . $i;
													(strcmp($value, $info[0]['yearLevel']) == 0) ? $state = 'selected' : $state = '';
												?>
													<option value="<?php echo $value ?>" <?php echo $state ?>><?php echo $value ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Email</span>
											<input type="email" name="email" class="form-control" id="emailFormControl" value="<?php echo $info[0]['email'] ?>" required>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Telephone No.</span>
											<input type="text" name="tel" class="form-control" value="<?php echo $info[0]['tel'] ?>" placeholder="09XXXXXXXXX" required>
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col-6">
											<span class="fs-5 fw-semibold">Gender</span>
											<select class="form-select" name="gender" required>
												<option value="" hidden>---</option>
												<?php
												foreach ($genders as $gender) {
													(strcmp($gender, $info[0]['gender']) == 0) ? $state = 'selected' : $state = '';
												?>
													<option value="<?php echo $gender ?>" <?php echo $state ?>><?php echo $gender ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="date" name="birthday" class="form-control" value="<?php echo $info[0]['birthday'] ?>" required>
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Address</span>
											<input type="text" name="address" class="form-control" value="<?php echo $info[0]['address'] ?>" required>
										</div>
									</div>
									<!--vaccine status-->
									<hr>
									<p class="fs-2" style="font-weight:900;">Vaccine Status</p>
									<div class="row mb-3 text-center">
										<p class="fs-4 fw-bold">1st Dose</p>
										<div class="col">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="date" name="firstdose" data-activate='input[type="text"][name="firstdoctor"], input[type="date"][name="seconddose"], select[name="vacbrand"]' data-required='input[type="text"][name="firstdoctor"], select[name="vacbrand"]' class="form-control" value="<?php echo $info[0]['firstdose'] ?>" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="text" name="firstdoctor" class="form-control" placeholder="Doctor" value="<?php echo $info[0]['firstdoctor'] ?>" autocomplete="off">
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<p class="fs-4 fw-bold">2nd Dose</p>
										<div class="col text-center">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="date" name="seconddose" data-activate='input[type="text"][name="seconddoctor"], input[type="date"][name="booster"]' data-required='input[type="text"][name="seconddoctor"]' class="form-control" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="text" name="seconddoctor" class="form-control" autocomplete="off">
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<div class="col-4 text-center" style="margin-left:33%;">
											<span class="fs-5 fw-semibold">Brand</span>
											<select class="form-select" name="vacbrand" autocomplete="off">
												<option value="" hidden>Brand</option>
												<?php
												foreach ($brand as $data) {
													(strcmp($data['brand'], $info[0]['vacbrand']) == 0) ? $state = 'selected' : $state = '';
												?>
													<option value="<?php echo $data['brand'] ?>" <?php echo $state ?>><?php echo $data['brand'] ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<p class="fs-4 fw-bold">Booster</p>
										<div class="col text-center">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="hidden" name="booster" class="form-control" value="">
											<input type="date" name="booster" data-activate='input[type="text"][name="boosterdoctor"], select[name="boosterbrand"]' data-required='input[type="text"][name="boosterdoctor"], select[name="boosterbrand"]' class="form-control" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="hidden" name="boosterdoctor" class="form-control" value="">
											<input type="text" name="boosterdoctor" class="form-control" autocomplete="off">
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<div class="col-6 text-center" style="margin-left:25%;">
											<span class="fs-5 fw-semibold">Booster Brand</span>
											<input type="hidden" name="boosterbrand" class="form-control" value="">
											<select class="form-select" name="boosterbrand" autocomplete="off">
												<option value="" hidden>Booster Brand</option>
												<?php
												foreach ($brand as $data) {
													(strcmp($data['brand'], $info[0]['boosterbrand']) == 0) ? $state = 'selected' : $state = '';
												?>
													<option value="<?php echo $data['brand'] ?>" <?php echo $state ?>><?php echo $data['brand'] ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
							</form>
						<?php
						}
						if (preg_match("/^F[0-9]{1,1}-[0-9]{6,6}$/", $_GET['id']) == 1) {
							$info = $conn->display('*', 'faculty INNER JOIN vaccinestatus ON faculty.id = vaccinestatus.id', "faculty.id='$id'");
							$name = explode(':', $info[0]['name']);
						?>
							<!-- Faculty -->
							<form id="accountInfo" data-validation="faculty" data-action="update">
								<div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">First Name</span>
											<input type="text" name="fname[]" class="form-control" value="<?php echo $name[0] ?>" autocomplete="off" required>
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Middle Name</span>
											<input type="text" name="mname[]" class="form-control" value="<?php echo $name[1] ?>" autocomplete="off" required>
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Last Name</span>
											<input type="text" name="lname[]" class="form-control" value="<?php echo $name[2] ?>" autocomplete="off" required>
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Email</span>
											<input type="email" name="email" class="form-control" value="<?php echo $info[0]['email'] ?>" required>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Telephone No.</span>
											<input type="text" name="tel" class="form-control" value="<?php echo $info[0]['tel'] ?>" placeholder="09XXXXXXXXX" required>
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col-6">
											<span class="fs-5 fw-semibold">Gender</span>
											<select class="form-select" name="gender" required>
												<option value="" hidden>---</option>
												<?php
												foreach ($genders as $gender) {
													(strcmp($gender, $info[0]['gender']) == 0) ? $state = 'selected' : $state = '';
												?>
													<option value="<?php echo $gender ?>" <?php echo $state ?>><?php echo $gender ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="date" name="birthday" class="form-control" value="<?php echo $info[0]['birthday'] ?>" required>
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Address</span>
											<input type="text" name="address" class="form-control" value="<?php echo $info[0]['address'] ?>" required>
										</div>
									</div>
									<hr>
									<p class="fs-2" style="font-weight:900;">Vaccine Status</p>
									<div class="row mb-3 text-center">
										<p class="fs-4 fw-bold">1st Dose</p>
										<div class="col">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="date" name="firstdose" data-activate='input[type="text"][name="firstdoctor"], input[type="date"][name="seconddose"], select[name="vacbrand"]' data-required='input[type="text"][name="firstdoctor"], select[name="vacbrand"]' class="form-control" value="<?php echo $info[0]['firstdose'] ?>" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="text" name="firstdoctor" class="form-control" placeholder="Doctor" value="<?php echo $info[0]['firstdoctor'] ?>" autocomplete="off">
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<p class="fs-4 fw-bold">2nd Dose</p>
										<div class="col text-center">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="date" name="seconddose" data-activate='input[type="text"][name="seconddoctor"], input[type="date"][name="booster"]' data-required='input[type="text"][name="seconddoctor"]' class="form-control" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="text" name="seconddoctor" class="form-control" autocomplete="off">
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<div class="col-4 text-center" style="margin-left:33%;">
											<span class="fs-5 fw-semibold">Brand</span>
											<select class="form-select" name="vacbrand" autocomplete="off">
												<option value="" hidden>Brand</option>
												<?php
												foreach ($brand as $data) {
													(strcmp($data['brand'], $info[0]['vacbrand']) == 0) ? $state = 'selected' : $state = '';
												?>
													<option value="<?php echo $data['brand'] ?>" <?php echo $state ?>><?php echo $data['brand'] ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<p class="fs-4 fw-bold">Booster</p>
										<div class="col text-center">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="hidden" name="booster" class="form-control" value="">
											<input type="date" name="booster" data-activate='input[type="text"][name="boosterdoctor"], select[name="boosterbrand"]' data-required='input[type="text"][name="boosterdoctor"], select[name="boosterbrand"]' class="form-control" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="hidden" name="boosterdoctor" class="form-control" value="">
											<input type="text" name="boosterdoctor" class="form-control" autocomplete="off">
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<div class="col-4 text-center" style="margin-left:33%;">
											<span class="fs-5 fw-semibold">Booster Brand</span>
											<select class="form-select" name="boosterbrand" autocomplete="off">
												<option value="" hidden>Booster Brand</option>
												<?php
												foreach ($brand as $data) {
													(strcmp($data['brand'], $info[0]['boosterbrand']) == 0) ? $state = 'selected' : $state = '';
												?>
													<option value="<?php echo $data['brand'] ?>" <?php echo $state ?>><?php echo $data['brand'] ?></option>
												<?php
												}
												?>

											</select>
										</div>
									</div>
								</div>
							</form>
						<?php
						}
						?>
					</div>
					<div class="modal" id="logout" tabindex="-1">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Log out</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<p>Are you sure?</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:rgb(16, 45, 65);color:white;">Cancel</button>
									<a href="login.html"><button type="button" class="btn" style="background-color:rgb(232, 177, 62);color:white;">Logout</button></a>
								</div>
							</div>
						</div>
					</div>


					<div>
						<!--TODO: CSS server response-->
						<form class="mb-5 mt-5" id="upload" method="post" enctype="multipart/form-data">
							<div>
								<label class="fs-2 fw-semibold file-upload">Upload <span style="color:rgb(237, 126, 0);">Vaccine</span> Card
									<input type="file" name="vaccinationCard">
									<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
										<path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z" />
										<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
									</svg>
									<button type="submit" class="btn btn-outline-success" style="margin-left:45px;">Upload</button>
									<p class="fw-bolder text-center text-success mt-2" style="font-size:16px;" id="filename"></p>
								</label>
							</div>
						</form>
					</div>
				</div>
				<div class="col-8 position-fixed" id="#settings" style="display: inline-block;">
					<span style="font-size:72px;"> content dito</span>
					<input type="email" name="email">
					<input type="password" name="password">
					<input type="password" name="confirmpass">
					<button id="change" data-activate='input[type="email"]:last, input[name="password"][name="confirmpass"]'>Change Password</button>
				</div>
			</div>
		</div>
	</main>
</body>

</html>