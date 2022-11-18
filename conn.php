<?php
//TODO:Refactor docx generation and redirect the file path to somewhere else

//autoloader cause lazy
require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpWord\Shared\Converter;

class connection
{
	private $servername = 'localhost';
	private $username = 'jay';
	private $password = 'password';
	private $dbname = 'Vaccine';
	private $conn;

	function __construct()
	{
		$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		if ($this->conn->connect_error) {
			echo 'Connection Failed';
		} else {
			return $this->conn;
		}
	}

	public function displayTable($table)
	{
		$sql = "SELECT * FROM $table";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
			return $data;
		}
	}

	public function displayRowByID($table, $col, $id)
	{
		$sql = "SELECT * FROM $table WHERE $col = '$id'";
		$result = $this->conn->query($sql);
		if ($result->num_rows != 0) {
			$row = $result->fetch_assoc();
			return $row;
		}
	}

	public function getColumnName($table, $count = 0)
	{
		$sql = "DESCRIBE `$table`";
		$result = $this->conn->query($sql);
		$colName = array();
		$colCount = 0;
		while ($row = $result->fetch_assoc()) {
			$colName[] = $row['Field'];
			$colCount++;
		}
		if ($count == 1) {
			return $colCount;
		}
		return $colName;
	}

	public function getData($table, $column)
	{
		$sql = "SELECT $column FROM $table";
		$result = $this->conn->query($sql);
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	//insert
	public function insertInfo($post, $table, $id = true, $formArr = NULL)
	{
		$keys = array_keys($post);
		print_r($keys);
		echo count($table);
		for ($count = 0; $count < count($table); $count++) {
			$colName = $this->getColumnName($table[$count]);
			$colCount = $this->getColumnName($table[$count], 1);
			$sql = "INSERT INTO $table[$count](";
			$ctr = 0;
			if (!$id) {
				$ctr = 1;
			}

			//gets the column name and concats into sql query
			for (; $ctr < $colCount; $ctr++) {
				if ($ctr < $colCount - 1) {
					$sql .= "$colName[$ctr], ";
				} else {
					$sql .= "$colName[$ctr])";
				}
			}
			$sql .= " VALUES(";


			for ($i = 0, $j = 0; $j < $colCount; $i++) {
				if (strcmp($keys[$i], $colName[$j]) == 0) {
					$value = $post[$keys[$i]];
					if (isset($formArr)) {
						$value = $post[$keys[$i]][$formArr];
					}
					if ($j < $colCount - 1) {
						//for those empty value
						if ($value == '') {
							$sql .= "NULL, ";
						} else {
							$sql .= "'$value', ";
						}
					} else {
						//for those empty value
						if ($value == '') {
							$sql .= "NULL)";
						} else {
							$sql .= "'$value')";
						}
					}
					$j++;
				}
			}
			echo $sql . "\n";
			$this->conn->query($sql);
		}
	}

	//update
	public function updateInfo($post, $table, $condition, $primaryKey, $id = true, $formArr = NULL)
	{
		$keys = array_keys($post);
		print_r($keys);
		for ($count = 0; $count < count($table); $count++) {
			$colName = $this->getColumnName($table[$count]);
			$colCount = $this->getColumnName($table[$count], 1);
			$sql = "UPDATE $table[$count] SET ";
			$j = 0;

			if ($count == 2) {
				$colCount -= 1;
			}

			if (!($id)) {
				$j = 1;
			}
			for ($i = 0; $i < count($keys); $i++) {
				if (strcmp($keys[$i], $colName[$j]) == 0) {
					$value = $post[$keys[$i]];
					if (isset($formArr)) {
						$value = $post[$keys[$i]][$formArr];
					}
					if ($j < $colCount - 1) {
						//for those empty value
						if ($value == '') {
							$sql .= "$colName[$j] = NULL, ";
							$j++;
						} else {
							$sql .= "$colName[$j] = '$value', ";
							$j++;
						}
					} else {
						//for those empty value
						if ($value == '') {
							$sql .= "$colName[$j] = NULL ";
							$j++;
						} else {
							$sql .= "$colName[$j] = '$value' ";
							$j++;
						}
					}
				}
			}
			$sql .= "WHERE $condition = '$primaryKey'";
			echo $sql;
			$this->conn->query($sql);
		}
	}

	//delete
	public function deleteInfo($table, $col, $id)
	{
		for ($i = 0; $i < count($table); $i++) {
			$sql = "DELETE FROM $table[$i] WHERE $col = '$id'";
			$this->conn->query($sql);
		}
	}

	public function find($table, $condition)
	{
		$sql = "SELECT * FROM $table WHERE $condition";
		$result = $this->conn->query($sql);
		return $result->num_rows;
	}

	//report generation using PHPOffice
	public function report()
	{
		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		//font style for texts
		$fStyle = [
			'bold' => true
		];
		$section = $phpWord->addSection();
		$section->addText('No. of Vaccinated', $fStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
		$table = ['student', 'faculty'];
		$header = $section->addHeader();

		//header content
		$header->addText(date('m/d/Y'), $fStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);
		//chart legends
		$categories = array('First Dose only', 'First and Second');
		$series = array();
		$i = 0;
		foreach ($table as $tableName) {
			//chart data
			$series[] = $this->find($tableName, 'firstdose IS NOT NULL and seconddose IS NULL');
			$series[] = $this->find($tableName, 'firstdose IS NOT NULL and seconddose IS NOT NULL');

			//chart style specification
			$style = [
				'width' => Converter::inchToEmu(3),
				'height' => Converter::inchToEmu(3),
				'title' => (ucfirst($tableName)),
				'showLegend' => true,
				'legendPosition' => 'b',
			];
			//chart creation
			$chart = $section->addChart('pie', $categories, $series, $style);
			$i++;
			unset($series);
			$section->addTextBreak();
		}

		$brand = $this->getData('vacBrand', 'brand');
		$i = 0;
		unset($categories);
		foreach ($table as $tableName) {
			foreach ($brand as $brandName) {
				$categories[] = $brandName['brand'];
				$temp = $brandName['brand'];
				$series[] = $this->find($tableName, "brand = '$temp'");
			}
			$style = [
				'width' => Converter::inchToEmu(3),
				'height' => Converter::inchToEmu(3),
				'title' => (ucfirst($tableName)),
				'showLegend' => true,
				'legendPosition' => 'b',
			];
			$chart = $section->addChart('pie', $categories, $series, $style);
			$i++;
			unset($categories);
			unset($series);
			$section->addTextBreak();
		}

		// Saving the document as DOCX file...
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save('Report.docx');
		header('location:adminview.php');
	}
}

$conn = new connection();
//feedback for the login
if (isset($_POST['type'])) {
	$id = $_POST['id'];
	$password = $_POST['password'];
	$result = $conn->find('logCredentials', "id = '$id'");
	$result += $conn->find('logCredentials', "id = '$id' and password ='$password'");
	switch ($result) {
		case 1:
			echo 'Wrong Password';
			break;
		case 2:
			echo '<script>location.href = "userview.php?id=' . $id . '"</script>';
			break;
		default:
			echo 'User Does not Exist';
			break;
	}
}

//feedback for image upload
if (isset($_FILES['vaccinationCard']['name'])) {
	$targetFile = "vaccine card/" . basename($_FILES['vaccinationCard']['name']);
	$uploadOk = 1;
	$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
	if (
		$fileType != "jpg" && $fileType != "png" &&
		$fileType != "jpeg"
	) {
		echo "Sorry, only JPG, JPEG and PNG are allowed";
		$uploadOk = 0;
	}

	if ($uploadOk != 0) {
		move_uploaded_file($_FILES["vaccinationCard"]["tmp_name"], $targetFile);
		echo 'Upload Succesful';
	} else {
		echo 'Upload unsuccessful';
	}
}

if (isset($_POST['tableName'])) {
	$row = $conn->getData($_POST['tableName'], $_POST['column']);
	echo json_encode($row);
}

if (isset($_POST['userID'])) {
	if ($_POST['userID'] == 1) {
		$info = $conn->displayRowByID('student', 'id', $_POST['id']);
		$name = explode(':', $info['name']);

?>
		<script src="script.js"></script>
		<div class="row mb-3">
			<div class="col">
				<input type="text" class="form-control" name="id[0]" placeholder="ID No." value="<?php echo $info['id'] ?>" autocomplete="off" required>
				<p class="fw-bolder text-center text-danger"></p>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<input type="text" name="fname[0]" class="form-control" placeholder="First name" value="<?php echo $name[0] ?>" autocomplete="off" required>
				<!--invalid feedback-->
				<p class="fw-bolder text-center text-danger"></p>
			</div>
			<div class="col">
				<input type="text" name="mname[0]" class="form-control" placeholder="Middle name" value="<?php echo $name[1] ?>" autocomplete="off" required>
				<!--invalid feedback-->
				<p class="fw-bolder text-center text-danger"></p>
			</div>
			<div class="col">
				<input type="text" name="lname[0]" class="form-control" placeholder="Last name" value="<?php echo $name[2] ?>" autocomplete="off" required>
				<!--invalid feedback-->
				<p class="fw-bolder text-center text-danger"></p>
				<input type="hidden" name="name[0]">
			</div>
		</div>
		<div class="row mb-3">
			<div class="col input-group">
				<select class="form-select" name="yearLevel[0]" required>
					<option value="" hidden>Year Level</option>
					<option value="Grade 7">Grade 7</option>
					<option value="Grade 8">Grade 8</option>
					<option value="Grade 9">Grade 9</option>
					<option value="Grade 10">Grade 10</option>
					<option value="Grade 11">Grade 11</option>
					<option value="Grade 12">Grade 12</option>
				</select>
			</div>
			<div class="col input-group">
				<select class="form-select" name="status[0]" required>
					<option value="" hidden>Status</option>
					<option value="Enrolled">Enrolled</option>
					<option value="Dropped">Dropped</option>
				</select>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<input type="email" name="email[0]" class="form-control" id="emailFormControl" value="<?php echo $info['email'] ?>" placeholder="Email" required>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<input type="text" name="tel[0]" class="form-control" placeholder="Telephone No." required>
				<!--Invalid Feedback-->
				<p></p>
			</div>
			<div class="col input-group">
				<select class="form-select" name="gender[0]" required>
					<option value="" hidden>Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<input type="date" name="birthday[0]" class="form-control" required>
				<!--TODO:Invalid Feedback-->
				<p></p>
			</div>
			<div class="col">
				<input type="text" name="address[0]" class="form-control" placeholder="Address" required>
			</div>
		</div>
		<hr>
		<div class="row mb-3 text-center">
			<p class="h5">Vaccine Status</p>
			<p class="h6">1st Dose</p>
			<div class="col text-center">
				<input type="hidden" name="firstdose[0]" class="form-control" value="">
				<input type="date" name="firstdose[0]" data-activate='input[type="text"][name="firstdoctor[0]"], input[type="date"][name="seconddose[0]"], select[name="vacbrand[0]"]' data-required='input[type="text"][name="firstdoctor[0]"], select[name="vacbrand[0]"]' class="form-control" autocomplete="off">
				<!--TODO:Invalid Feedback-->
				<p></p>
			</div>
			<div class="col">
				<input type="hidden" name="firstdoctor[0]" class="form-control" value="">
				<input type="text" name="firstdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
				<!--invalid feedback-->
				<p class="fw-bolder text-center text-danger"></p>
			</div>
		</div>
		<div class="row mb-3 text-center">
			<p class="h6">2nd Dose</p>
			<div class="col text-center">
				<input type="hidden" name="seconddose[0]" class="form-control" value="">
				<input type="date" name="seconddose[0]" data-activate='input[type="text"][name="seconddoctor[0]"], input[type="date"][name="booster[0]"]' data-required='input[type="text"][name="seconddoctor[0]"]' class="form-control" autocomplete="off" disabled>
				<!--TODO:Invalid Feedback-->
				<p></p>
			</div>
			<div class="col">
				<input type="hidden" name="seconddoctor[0]" class="form-control" value="">
				<input type="text" name="seconddoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
				<!--invalid feedback-->
				<p class="fw-bolder text-center text-danger"></p>
			</div>
		</div>
		<div class="row mb-3 text-center">
			<div class="col text-center">
				<input type="hidden" name="vacbrand[0]" class="form-control" value="">
				<select class="form-select" name="vacbrand[0]" autocomplete="off" disabled>
					<option value="" hidden>Brand</option>
				</select>
			</div>
		</div>
		<div class="row mb-3 text-center">
			<p class="h6">Booster</p>
			<div class="col text-center">
				<input type="hidden" name="booster[0]" class="form-control" value="">
				<input type="date" name="booster[0]" data-activate='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' data-required='input[type="text"][name="boosterdoctor[0]"], select[name="boosterbrand[0]"]' class="form-control" autocomplete="off" disabled>
				<!--TODO:Invalid Feedback-->
				<p></p>
			</div>
			<div class="col">
				<input type="hidden" name="boosterdoctor[0]" class="form-control" value="">
				<input type="text" name="boosterdoctor[0]" class="form-control" placeholder="Doctor" autocomplete="off" disabled>
				<!--invalid feedback-->
				<p class="fw-bolder text-center text-danger"></p>
			</div>
		</div>
		<div class="row mb-3 text-center">
			<div class="col text-center">
				<input type="hidden" name="boosterbrand[0]" class="form-control" value="">
				<select class="form-select" name="boosterbrand[0]" autocomplete="off" disabled>
					<option value="" hidden>Booster Brand</option>
				</select>
			</div>
		</div>

<?php
	} else {
		echo 'faculty';
	}
}
