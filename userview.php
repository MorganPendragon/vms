<!DOCTYPE html>
<html lang="en">
<!--TODO: Sign up-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Student View</title>
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
</style>

<body>

	<main>
		<div class="row">
			<!--sidebar-->
			<div class="col-2 position-fixed" style="background-color:#022e43;font-size:20px; height:100vh;" tabindex="1">
				<img src="img\logo.png" class="img-fluid" alt="...">
				<ul class="nav nav-pills mb-sm-auto mb-0 align-items-center align-items-sm-start" id="sidebar">
					<li class="nav-item">
						<a href="#account" class="nav-link active" style="color:rgb(232, 177, 62);" data-show="#account" data-hide="#settings"><i class="bi bi-person-fill"></i>&nbsp;&nbsp;Account Information</a>
					</li>
					<li class="nav-item">
						<a href="#settings" class="nav-link" style="color:rgb(232, 177, 62);" data-show="#settings" data-hide="#account"><i class="bi bi-gear-fill"></i>&nbsp;&nbsp;Settings</a>
					</li>
				</ul>
			</div>
			<!--content-->
			<div class="col-8 position-absolute" style="margin-left:25%;">
				<div id="account">
					<div class="d-flex">
						<span class="fs-1" style="font-weight:900;">Account Information</span>
						<div class=" gap-2" style="margin-left:30%;">
							<button class="btn button rounded-pill mt-2 fs-5" style="background-color:rgb(16, 45, 65); color:white" id="edit" data-hide="#edit" data-show="#save, #cancel" type="button">Edit</button>
							<button class="btn button rounded-pill mt-2 fs-5" style="background-color:rgb(237, 126, 0); color:white; display:none;" id="save" data-hide="#save, #cancel" data-show="#edit" type="button">Save</button>
							<button class="btn button rounded-pill mt-2 fs-5" style="background-color:rgb(237, 126, 0); color:white; display:none;" id="cancel" data-hide="#save, #cancel" data-show="#edit" type="button">cancel</button>
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
						if (preg_match("/^[0-9]{1,2}-[0-9]{6,6}$/", $_GET['id']) == 1) {
							$info = $conn->display('student', 'id', $_GET['id']);
							$vacStatus = $conn->display('vaccinestatus', 'id', $_GET['id']);
							$name = explode(':', $info['name']);
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
													(strcmp($value, $info['yearLevel']) == 0) ? $state = 'selected' : $state = '';
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
											<input type="email" name="email" class="form-control" id="emailFormControl" value="<?php echo $info['email'] ?>" required>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Telephone No.</span>
											<input type="text" name="tel" class="form-control" value="<?php echo $info['tel'] ?>" placeholder="09XXXXXXXXX" required>
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col-6">
											<span class="fs-5 fw-semibold">Gender</span>
											<select class="form-select" name="gender" required>
												<option value="" hidden>---</option>
												<?php
												foreach ($genders as $gender) {
													(strcmp($gender, $info['gender']) == 0) ? $state = 'selected' : $state = '';
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
											<input type="date" name="birthday" class="form-control" value="<?php echo $info['birthday'] ?>" required>
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Address</span>
											<input type="text" name="address" class="form-control" value="<?php echo $info['address'] ?>" required>
										</div>
									</div>
									<!--vaccine status-->
									<hr>
									<p class="fs-2" style="font-weight:900;">Vaccine Status</p>
									<div class="row mb-3 text-center">
										<?php
										(isset($vacStatus['firstdose'])) ? $state = 'required' : $state = 'disabled';
										?>
										<p class="fs-4 fw-bold">1st Dose</p>
										<div class="col">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="date" name="firstdose" data-activate='input[type="text"][name="firstdoctor"], input[type="date"][name="seconddose"], select[name="vacbrand"]' data-required='input[type="text"][name="firstdoctor"], select[name="vacbrand"]' class="form-control" value="<?php echo $vacStatus['firstdose'] ?>" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="text" name="firstdoctor" class="form-control" placeholder="Doctor" value="<?php echo $vacStatus['firstdoctor'] ?>" autocomplete="off" <?php echo $state ?>>
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
											<select class="form-select" name="vacbrand" value="<?php echo $vacStatus['vacbrand'] ?>" autocomplete="off">
												<option value="" hidden>Brand</option>
												<?php
												foreach ($brand as $data) {
													(strcmp($data['brand'], $vacStatus['vacbrand']) == 0) ? $state = 'selected' : $state = '';
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
										<div class="col-6 text-center" style="margin-left:33%;">
											<span class="fs-5 fw-semibold">Booster Brand</span>
											<input type="hidden" name="boosterbrand" class="form-control" value="">
											<select class="form-select" name="boosterbrand" autocomplete="off">
												<option value="" hidden>Booster Brand</option>
											</select>
										</div>
									</div>
								</div>
							</form>
						<?php
						}
						if (preg_match("/^F[0-9]{1,1}-[0-9]{6,6}$/", $_GET['id']) == 1) {
							$info = $conn->display('faculty', 'id', $_GET['id']);
							$name = str_replace(':', ' ', $info['name']);
						?>
							<!-- Faculty -->
							<form id="accountInfo" data-validation="faculty" data-action="update">
								<div>
									<div>
										<div class="row mb-3">
											<div class="col">
												<input type="hidden" name="id" value="<?php echo $info['id'] ?>">
												<span class="fs-5 fw-semibold">Full Name</span>
												<input type="text" name="name" value="<?php echo $name ?>" class="form-control">
												<!--invalid feedback-->
												<p class="fw-bolder text-center text-danger"></p>
											</div>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Email</span>
											<input type="email" name="email" class="form-control" id="emailFormControl" value="<?php echo $info['email'] ?>" required>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Telephone No.</span>
											<input type="text" name="tel" class="form-control" value="<?php echo $info['tel'] ?>" placeholder="09XXXXXXXXX" required>
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col ">
											<span class="fs-5 fw-semibold">Gender</span>
											<select class="form-select" name="gender" required>
												<option value="" hidden>Gender</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="date" name="birthday" class="form-control" value="<?php echo $info['birthday'] ?>" required>
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Address</span>
											<input type="text" name="address" class="form-control" value="<?php echo $info['address'] ?>" required>
										</div>
									</div>
									<hr>
									<p class="fs-2" style="font-weight:900;">Vaccine Status</p>
									<div class="row mb-3 text-center">
										<p class="fs-4 fw-bold">1st Dose</p>
										<div class="col">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="hidden" name="firstdose" class="form-control" value="">
											<input type="date" name="firstdose" data-activate='input[type="text"][name="firstdoctor[2]"], input[type="date"][name="seconddose[2]"], select[name="vacbrand[2]"]' data-required='input[type="text"][name="firstdoctor[2]"], select[name="vacbrand[2]"]' class="form-control" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="hidden" name="firstdoctor" class="form-control" value="">
											<input type="text" name="firstdoctor" class="form-control" placeholder="Doctor" autocomplete="off">
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<p class="fs-4 fw-bold">2nd Dose</p>
										<div class="col text-center">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="hidden" name="seconddose" class="form-control" value="">
											<input type="date" name="seconddose" data-activate='input[type="text"][name="seconddoctor[2]"], input[type="date"][name="booster[2]"]' data-required='input[type="text"][name="seconddoctor[2]"]' class="form-control" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="hidden" name="seconddoctor" class="form-control" value="">
											<input type="text" name="seconddoctor" class="form-control" placeholder="Doctor" autocomplete="off">
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<div class="col-4 text-center" style="margin-left:33%;">
											<span class="fs-5 fw-semibold">Brand</span>
											<input type="hidden" name="vacbrand" class="form-control" value="">
											<select class="form-select" name="vacbrand" autocomplete="off">
												<option hidden>Brand</option>
											</select>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<p class="fs-4 fw-bold">Booster</p>
										<div class="col text-center">
											<span class="fs-5 fw-semibold">Date</span>
											<input type="hidden" name="booster" class="form-control" value="">
											<input type="date" name="booster" data-activate='input[type="text"][name="boosterdoctor[2]"], select[name="boosterbrand[2]"]' data-required='input[type="text"][name="boosterdoctor[2]"], select[name="boosterbrand[2]"]' class="form-control" autocomplete="off">
											<!--Invalid Feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
										<div class="col">
											<span class="fs-5 fw-semibold">Doctor</span>
											<input type="hidden" name="boosterdoctor" class="form-control" value="">
											<input type="text" name="boosterdoctor" class="form-control" placeholder="Doctor" autocomplete="off">
											<!--invalid feedback-->
											<p class="fw-bolder text-center text-danger"></p>
										</div>
									</div>
									<div class="row mb-3 text-center">
										<div class="col-4 text-center" style="margin-left:33%;">
											<span class="fs-5 fw-semibold">Booster Brand</span>
											<input type="hidden" name="boosterbrand" class="form-control" value="">
											<select class="form-select" name="boosterbrand" autocomplete="off">
												<option hidden>Booster Brand</option>
											</select>
										</div>
									</div>
								</div>
							</form>
					</div>
				<?php
						}
				?>
				<div>
					<!--TODO: CSS server response-->
					<form class="mb-5" id="upload" method="post" enctype="multipart/form-data">
						<p class="fw-bolder text-center text-success"></p>
						Select image to upload:
						<input type="file" name="vaccinationCard">
						<button type="submit" class="btn btn-primary">Upload</button>
					</form>
				</div>
				</div>
			</div>
			<div class="col-8 position-fixed" id="#settings" style="display: inline-block;">
				content here
			</div>
		</div>
		</div>
		</div>
	</main>
</body>

</html>