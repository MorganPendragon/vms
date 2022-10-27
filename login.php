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
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	<title>Log In</title>
	<style>
		.window-height {
			height: 100vh;
		}

		* {
			box-sizing: border-box;
			font-family: 'Montserrat';
		}

		.bg-img {
			/* The image used */
			background-image: url("img/background.png");
			background-position: center;
			background-size: cover;
			box-shadow: 10px 10px 10px;
		}

		.card {
			border-radius: 30px;

			box-shadow: 20px 20px 10px;
		}
	</style>
</head>

<body>
	<div class="bg-img">
		<div class="container">
			<div class="d-flex align-items-center window-height flex-column">
				<div class="d-flex justify-content-center">
					<img src="img\test.png" class="back img-fluid">
				</div>
				<div class="col-4">
					<div class="card text-center">
						<div class="card-header">
							<form id="login">
								<div class="card-body">
									<div class="mb-3">
										<input type="text" class="form-control text-center" id="idNo" placeholder="ID Number" required>
										<div id="idFeedback"></div>
									</div>
									<div class="mb-3">
										<input type="password" id="pwd" class="form-control text-center" placeholder="**********" required>
										<div id="pwdFeedback" class="invalid-feedback"></div>
									</div>
									<div class="d-grid mb-3 gap-2 col-6 mx-auto">
										<button type="submit" class="btn btn-primary">Log In</button>
									</div>
								</div>
							</form>
						</div>
						<div class="card-footer py-4 ">
							<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#signup">
								Sign Up
							</button>
							<div class="modal fade" id="signup" tabindex="-1" aria-labelledby="signup" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h1 class="modal-title fs-5 " id="signup">Registration</h1>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											...
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
</body>

</html>