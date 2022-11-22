<!DOCTYPE html>
<html lang="en">

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
			var $_GET = {};

			document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function() {
				function decode(s) {
					return decodeURIComponent(s.split("+").join(" "));
				}

				$_GET[decode(arguments[1])] = decode(arguments[2]);
			});
			var id = $_GET['id'];

			//AJAX request info
			if (/^[0-9]{1,2}-[0-9]{6,6}$/.test(id)) {
				$('#settings').load('conn.php', {
					userID: 1,
					id: id
				});
			} else {
				$('#settings').load('conn.php', {
					userID: 2,
					id: id
				});
			}
			$('input[type!=file][id!=upload], select').attr('disabled', 'disabled');
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
						<div class="d-flex gap-2" style="margin-left:50%;">
							<button class="btn rounded-pill mt-2 fs-5" style="background-color:rgb(16, 45, 65); color:white" type="button">Edit</button>
							<button class="btn rounded-pill mt-2 fs-5" style="background-color:rgb(237, 126, 0); color:white" type="button">Save</button>
						</div>
					</div>
					<div id="disabled">
						<div class="row mb-3">
						</div>
						<?php

						if (preg_match("/^[0-9]{1,2}-[0-9]{6,6}$/", $_GET['id']) == 1) {
						?>
						<!--student-->
							<div>
								<div class="row mb-3">
									<div class="col">
										<span class="fs-5 fw-semibold">ID No.</span>
										<input type="text" class="form-control" name="id[0]" placeholder="ID No." value="<?php echo $info['id'] ?>" autocomplete="off" required>
										<p class="fw-bolder text-center text-danger"></p>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col">
										<span class="fs-5 fw-semibold">Full Name</span>
										<input type="text" name="name[0]" class="form-control">
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col">
										<span class="fs-5 fw-semibold">Year Level</span>
										<select class="form-select" name="yearLevel[0]" required>
											<option value="" hidden>---</option>
											<option value="Grade 7">Grade 7</option>
											<option value="Grade 8">Grade 8</option>
											<option value="Grade 9">Grade 9</option>
											<option value="Grade 10">Grade 10</option>
											<option value="Grade 11">Grade 11</option>
											<option value="Grade 12">Grade 12</option>
										</select>
									</div>
									<div class="col">
										<span class="fs-5 fw-semibold">Status</span>
										<select class="form-select" name="status[0]" required>
											<option value="" hidden>---</option>
											<option value="Enrolled">Enrolled</option>
											<option value="Dropped">Dropped</option>
										</select>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col">
										<span class="fs-5 fw-semibold">Email</span>
										<input type="email" name="email[0]" class="form-control" id="emailFormControl" value="<?php echo $info['email'] ?>" required>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col">
										<span class="fs-5 fw-semibold">Telephone No.</span>
										<input type="text" name="tel[0]" class="form-control" placeholder="09XXXXXXXXX" required>
										<!--Invalid Feedback-->
										<p></p>
									</div>
									<div class="col-6">
										<span class="fs-5 fw-semibold">Gender</span>
										<select class="form-select" name="gender[0]" required>
											<option value="" hidden>---</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col">
										<span class="fs-5 fw-semibold">Date</span>
										<input type="date" name="birthday[0]" class="form-control" required>
										<!--TODO:Invalid Feedback-->
										<p></p>
									</div>
									<div class="col">
										<span class="fs-5 fw-semibold">Address</span>
										<input type="text" name="address[0]" class="form-control" required>
									</div>
								</div>
								<!--vaccine status-->
								<hr>
								<p class="fs-2" style="font-weight:900;">Vaccine Status</p>
								<div class="row mb-3 text-center">
									<p class="fs-4 fw-bold">1st Dose</p>
									<div class="col">
										<span class="fs-5 fw-semibold">Date</span>
										<input type="hidden" name="firstdose[0]" class="form-control" value="">
										<input type="date" name="firstdose[0]" data-activate='input[type="text"][name="firstdoctor[0]"], input[type="date"][name="seconddose[0]"], select[name="vacbrand[0]"]' data-required='input[type="text"][name="firstdoctor[0]"], select[name="vacbrand[0]"]' class="form-control" autocomplete="off">
										<!--TODO:Invalid Feedback-->
										<p></p>
									</div>
									<div class="col">
										<span class="fs-5 fw-semibold">Doctor</span>
										<input type="hidden" name="firstdoctor[0]" class="form-control" value="">
										<input type="text" name="firstdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
									</div>
								</div>
								<div class="row mb-3 text-center">
									<p class="fs-4 fw-bold">2nd Dose</p>
									<div class="col text-center">
										<span class="fs-5 fw-semibold">Date</span>
										<input type="hidden" name="seconddose[0]" class="form-control" value="">
										<input type="date" name="seconddose[0]" data-activate='input[type="text"][name="seconddoctor[0]"], input[type="date"][name="booster[0]"]' data-required='input[type="text"][name="seconddoctor[0]"]' class="form-control" autocomplete="off" disabled>
										<!--TODO:Invalid Feedback-->
										<p></p>
									</div>
									<div class="col">
										<span class="fs-5 fw-semibold">Doctor</span>
										<input type="hidden" name="seconddoctor[0]" class="form-control" value="">
										<input type="text" name="seconddoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
									</div>
								</div>
								<div class="row mb-3 text-center">
									<div class="col-4 text-center" style="margin-left:33%;">
										<span class="fs-5 fw-semibold">Brand</span>
										<input type="hidden" name="vacbrand[0]" class="form-control" value="">
										<select class="form-select" name="vacbrand[0]" autocomplete="off" disabled>
											<option value="" hidden>Brand</option>
										</select>
									</div>
								</div>
								<div class="row mb-3 text-center">
									<p class="fs-4 fw-bold">Booster</p>
									<div class="col text-center">
										<span class="fs-5 fw-semibold">Date</span>
										<input type="hidden" name="booster[0]" class="form-control" value="">
										<input type="date" name="booster[0]" data-activate='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' data-required='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' class="form-control" autocomplete="off" disabled>
										<!--TODO:Invalid Feedback-->
										<p></p>
									</div>
									<div class="col">
										<span class="fs-5 fw-semibold">Doctor</span>
										<input type="hidden" name="boosterdoctor[0]" class="form-control" value="">
										<input type="text" name="boosterdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
									</div>
								</div>
								<div class="row mb-3 text-center">
									<div class="col text-center">
										<span class="fs-5 fw-semibold">Booster Brand</span>
										<input type="hidden" name="boosterbrand[0]" class="form-control" value="">
										<select class="form-select" name="boosterbrand[0]" autocomplete="off" disabled>
											<option value="" hidden>Booster Brand</option>
										</select>
									</div>
								</div>
							</div>
						<?php
						}
						if (preg_match("/^F[0-9]{1,1}-[0-9]{6,6}$/", $_GET['id']) == 1) {
						?>
						
							<div>
								<div class="row mb-3">
									<div class="col">
										<input type="text" name="id[1]" class="form-control" placeholder="ID no." autocomplete="off" required>
										<p class="fw-bolder text-center text-danger"></p>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col">
										<input type="text" name="fname[1]" class="form-control" placeholder="First name" autocomplete="off" required>
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
									</div>
									<div class="col">
										<input type="text" name="mname[1]" class="form-control" placeholder="Middle name" autocomplete="off" required>
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
									</div>
									<div class="col">
										<input type="text" name="lname[1]" class="form-control" placeholder="Last name" autocomplete="off" required>
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
										<input type="hidden" name="name[1]">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col">
										<input type="email" name="email[1]" class="form-control" id="emailFormControl" placeholder="Email" required>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col">
										<input type="text" name="tel[1]" class="form-control" placeholder="Telephone No." required>
										<!--Invalid Feedback-->
										<p></p>
									</div>
									<div class="col input-group">
										<select class="form-select" name="gender[1]" required>
											<option value="" hidden>Gender</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col">
										<input type="date" name="birthday[1]" class="form-control" required>
										<!--TODO:Invalid Feedback-->
										<p></p>
									</div>
									<div class="col">
										<input type="text" name="address[1]" class="form-control" placeholder="Address" required>
									</div>
								</div>
								<hr>
								<div class="row mb-3 text-center">
									<p class="h5">Vaccine Status</p>
									<p class="h6">1st Dose</p>
									<div class="col text-center">
										<input type="hidden" name="firstdose[1]" class="form-control" value="">
										<input type="date" name="firstdose[1]" data-activate='input[type="text"][name="firstdoctor[2]"], input[type="date"][name="seconddose[2]"], select[name="vacbrand[2]"]' data-required='input[type="text"][name="firstdoctor[2]"], select[name="vacbrand[2]"]' class="form-control" autocomplete="off">
										<!--TODO:Invalid Feedback-->
										<p></p>
									</div>
									<div class="col">
										<input type="hidden" name="firstdoctor[1]" class="form-control" value="">
										<input type="text" name="firstdoctor[1]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
									</div>
								</div>
								<div class="row mb-3 text-center">
									<p class="h6">2nd Dose</p>
									<div class="col text-center">
										<input type="hidden" name="seconddose[1]" class="form-control" value="">
										<input type="date" name="seconddose[1]" data-activate='input[type="text"][name="seconddoctor[2]"], input[type="date"][name="booster[2]"]' data-required='input[type="text"][name="seconddoctor[2]"]' class="form-control" autocomplete="off" disabled>
										<!--TODO:Invalid Feedback-->
										<p></p>
									</div>
									<div class="col">
										<input type="hidden" name="seconddoctor[1]" class="form-control" value="">
										<input type="text" name="seconddoctor[1]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
									</div>
								</div>
								<div class="row mb-3 text-center">
									<div class="col text-center">
										<input type="hidden" name="vacbrand[1]" class="form-control" value="">
										<select class="form-select" name="vacbrand[1]" autocomplete="off" disabled>
											<option hidden>Brand</option>
										</select>
									</div>
								</div>
								<div class="row mb-3 text-center">
									<p class="h6">Booster</p>
									<div class="col text-center">
										<input type="hidden" name="booster[1]" class="form-control" value="">
										<input type="date" name="booster[1]" data-activate='input[type="text"][name="boosterdoctor[2]"], select[name="boosterbrand[2]"]' data-required='input[type="text"][name="boosterdoctor[2]"], select[name="boosterbrand[2]"]' class="form-control" autocomplete="off" disabled>
										<!--TODO:Invalid Feedback-->
										<p></p>
									</div>
									<div class="col">
										<input type="hidden" name="boosterdoctor[1]" class="form-control" value="">
										<input type="text" name="boosterdoctor[1]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
										<!--invalid feedback-->
										<p class="fw-bolder text-center text-danger"></p>
									</div>
								</div>
								<div class="row mb-3 text-center">
									<div class="col text-center">
										<input type="hidden" name="boosterbrand[1]" class="form-control" value="">
										<select class="form-select" name="boosterbrand[1]" autocomplete="off" disabled>
											<option hidden>Booster Brand</option>
										</select>
									</div>
								</div>
							</div>
						<?php
						}
						?>
						<div>
							<!--TODO: CSS server response-->
							<form class="mb-5" id="upload" method="post" enctype="multipart/form-data">
								<p></p>
								Select image to upload:
								<input type="file" name="vaccinationCard">
								<button type="submit" id="upload" class="btn btn-primary">Upload</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-8 position absolute" id="#settings">
					content here 
				</div>
			</div>
		</div>
	</main>
</body>

</html>