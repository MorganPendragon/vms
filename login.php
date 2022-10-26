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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>
	<script src="script.js"></script>
	<title>Log In</title>
</head>
<style>
	.window-height {
		height: 100vh;
	}
</style>

<body>

	<div class="container">
		<div class="row justify-content-end align-items-center window-height">
			<div class="col-sm-8">
				<div class="image-fluid mb-5" style="width: 60vh; ">
					<img src="img\doctor.jpg" class="card-img-top rounded-circle" alt="...">
					<p class="fs-4 text-center">We Care for your better Future</p>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card text-center">
					<div class="card-header">
						<form id="login">
							<div class="mb-3">
								<label for="idNo" class="form-label">ID No.</label>
								<input type="text" class="form-control" id="idNo" placeholder="ID No." required>
								<div id="idFeedback"></div>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label">Password</label>
								<input type="password" class="form-control"
									placeholder="**********" required>
								<div id="password-validation" class="invalid-feedback"></div>
							</div>
							<div class="mb-3 gap-2 col-6 mx-auto">
								<button type="submit" class="btn btn-primary">Log In</button>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>