<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Log In</title>
</head>
<style>
    .window-height {
        height: 100vh;
    }

    .footer {

        position: absolute;
        left: 0;
        right: 0;
        width: 100%;
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
                        <form class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" required id="phone" placeholder="09123456789" pattern="[0-9]{11}" required>
                                <div id="tel-validation" class="invalid-feedback">PLEASE INPUT A VALID PHONE NUMBER</div>
                            </div>
                            <div class="mb-3 gap-2 col-6 mx-auto">
                                <a href="adminview.php"><button type="submit" class="btn btn-primary">Check Status</button></a>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        		// Example starter JavaScript for disabling form submissions if there are invalid fields
		(function () {
			'use strict'

			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.querySelectorAll('.needs-validation')

			// Loop over them and prevent submission
			Array.prototype.slice.call(forms)
				.forEach(function (form) {
					form.addEventListener('submit', function (event) {
						if (!form.checkValidity()) {
							event.preventDefault()
							event.stopPropagation()
						}

						form.classList.add('was-validated')
					}, false)
				})
		})()
    </script>
</body>
<footer class="footer">
    <ul class="nav justify-content-center mb-5" style="width:100%; background-color: #e3f2fd;">
        <li class="nav-item">
            <a class="nav-link" href="#">Filipino</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Korean</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Chinese</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Japanese</a>
        </li>
    </ul>
</footer>

</html>