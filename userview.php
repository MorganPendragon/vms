<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Student View</title>

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
				$.post({
					url: 'conn.php',
					data: {
						userID: 2,
						id: id
					},
					success: function(response) {
						$('#account').text(response);
					}
				});
			}
		});
	</script>
</head>

<body>
	<header>
		<div class="row">
			<nav class="navbar" style="background-color: #022e43"></nav>
		</div>
	</header>
	<main>
		<div class="row">
			<!--sidebar-->
			<div class="col-2" style="background-color:#022e43; height:100vh;" tabindex="1">
				<img src="img\logo.png" class="img-fluid" alt="...">
				<ul class="nav nav-pills nav-stacked" id="sidebar">
					<li class="nav-item">
						<a href="#account" class="nav-link active" data-show="#account" data-hide="#vaccineCard">&nbsp;&nbsp;Account Information</a>
					</li>
					<li class="nav-item">
						<a href="#vaccineCard" class="nav-link" data-show="#vaccineCard" data-hide="#account">&nbsp;&nbsp;Upload</a>
					</li>
				</ul>
			</div>
			<!--content-->
			<div class="col-8">
				<div id="account">
					<div>
						<button class="btn btn-primary" type="button">Edit</button>
						<button class="btn btn-primary" type="button">Save</button>
					</div>
					<div id="settings">

					</div>
					<div>
						<!--TODO: CSS server response-->
						<form id="upload" method="post" enctype="multipart/form-data">
							<p></p>
							Select image to upload:
							<input type="file" name="vaccinationCard">
							<button type="submit" class="btn btn-primary">Upload</button>
						</form>
					</div>
				</div>
				<div id="vaccineCard" style="display: none;">

				</div>
			</div>
		</div>
	</main>
</body>

</html>