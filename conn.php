<?php
//TODO:Refactor docx generation and redirect the file path to somewhere else

//autoloader cause lazy
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class connection
{
	private $servername = 'localhost';
	private $username = 'jay';
	private $password = 'password';
	private $dbname = 'Vaccine';
	private $conn;
	private $mail;

	function __construct()
	{
		$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		if ($this->conn->connect_error) {
			echo 'Connection Failed';
		} else {
			return $this->conn;
		}
	}

	public function __call($name, $arguments)
	{
		if ($name == 'display') {
			switch (count($arguments)) {
				case 2:
					$sql = "SELECT $arguments[0] FROM $arguments[1]";
					$result = $this->conn->query($sql);
					if ($result->num_rows != 0) {
						while ($row = $result->fetch_assoc()) {
							$data[] = $row;
						}
						return $data;
					} else {
						return $data = array();
					}
				case 3:
					$sql = "SELECT $arguments[0] FROM $arguments[1] WHERE $arguments[2]";
					$result = $this->conn->query($sql);
					if ($result->num_rows != 0) {
						while ($row = $result->fetch_assoc()) {
							$data[] = $row;
						}
						return $data;
					} else {
						return $data = array();
					}
			}
		}
		if ($name == 'mailer') {
			$this->mail = new PHPMailer();
			$this->mail->IsSMTP();
			//Set the hostname of the mail server
			$this->mail->Host = 'smtp.gmail.com';

			//Set the SMTP port number:
			// - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
			// - 587 for SMTP+STARTTLS
			$this->mail->Port = 587;

			//Whether to use SMTP authentication
			$this->mail->SMTPAuth = true;

			$this->mail->SMTPSecure = 'tls';
			$this->mail->Username = 'oceansofknowledge.ph@gmail.com';
			$this->mail->Password = 'jrue sfcu dcal wets';
			$this->mail->setFrom('oceansofknowledge.ph@gmail.com', 'Oceans of Knowledge');
			return $this->mail;
		}
		//send email
		if ($name == 'sendMail') {
			switch ($arguments[0]) {
				case 'sendCredentials':
					$message = file_get_contents('logincredentials.html');
					$message = str_replace('%idNo%', $arguments[1], $message);
					$message = str_replace('%password%', $arguments[2], $message);
					$this->mail->Subject = 'Log In Credentials';
					$this->mail->AddEmbeddedImage('./img/logo.png', 'logo');
					$this->mail->isHTML(true);
					$this->mail->msgHTML($message);
					$this->mail->addAddress($arguments[3]);
					$this->mail->send();
					break;
				case 'updatedID':

					break;
			}
		}

		if ($name == 'report') {
			$phpWord = new \PhpOffice\PhpWord\PhpWord();
			$headerFontStyle = ['size' => 16, 'bold' => true];
			$title = 'Title';
			$categories = [1, 2, 3, 4];
			$series = [5, 1, 3, 5];
			$chartStyle = [
				'showLegend' => true,
				'LegendPostion' => 'b', 'title' => $title,
				'width' => Converter::inchToEmu(3),
				'height' => Converter::inchToEmu(4),
				'colors' => ['3A557A', '90B7CD', 'D4EEEE', 'F2AE08', 'E26749', 'ED7E00'],
			];

			$section = $phpWord->addSection(['breakType' => 'continous']);
			$section->addText('First Dose Only', $headerFontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
			$table = $section->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'borderColor' => 'FFFFFF']);
			$table->addRow(5000);
			$table->addCell(5000)->addChart('pie', $categories, $series, $chartStyle);
			$table->addCell(5000)->addChart('pie', $categories, $series, $chartStyle);
			$section->addTextBreak();
			$section->addText('Completed', $headerFontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
			$table = $section->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'borderColor' => 'FFFFFF']);
			$table->addRow(5000);
			$table->addCell(5000)->addChart('pie', $categories, $series, $chartStyle);
			$table->addCell(5000)->addChart('pie', $categories, $series, $chartStyle);
			$section->addTextBreak();
			$section->addText('', $headerFontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
			$table = $section->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'borderColor' => 'FFFFFF']);
			$table->addRow(5000);
			$table->addCell(5000)->addChart('pie', $categories, $series, $chartStyle);
			$table->addCell(5000)->addChart('pie', $categories, $series, $chartStyle);


			$post = array('table' => '1', 'student' => '1');
			//TODO:table data
			if (isset($post['table'])) {
				$section = $phpWord->addSection(['orientation' => 'landscape']);
				if (isset($post['student'])) {
					$section->addText('Student', $headerFontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
					//student
					$tableHeaderName = ['ID', 'Name', 'Gender', 'Year Level', 'First Dose', 'Second Dose', 'Vaccine Manufacturer', 'Booster', 'Booster Manufacturer'];
					//keys for the data
					$keys = ['id', 'name', 'gender', 'yearLevel', 'firstdose', 'seconddose', 'vacbrand', 'booster', 'boosterbrand'];
					//table header
					$data = $this->display('*', 'student INNER JOIN vaccinestatus ON student.id = vaccinestatus.id');
					$this->tableDocx($section, $tableHeaderName, $data, $keys);
				}

				if (isset($post['faculty'])) {
					$section->addText('Faculty', $headerFontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
					//faculty
					$tableHeaderName = ['ID', 'Name', 'Gender', 'First Dose', 'Second Dose', 'Vaccine Manufacturer', 'Booster', 'Booster Manufacturer'];
					//keys for the data
					$keys = ['id', 'name', 'gender', 'firstdose', 'seconddose', 'vacbrand', 'booster', 'boosterbrand'];
					//table header
					$data = $this->display('*', 'faculty INNER JOIN vaccinestatus ON faculty.id = vaccinestatus.id');
					$this->tableDocx($section, $tableHeaderName, $data, $keys);
				}
			}
			$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
			if (file_exists('Reports.docx')) {
				unlink(realpath('Reports.docx'));
				$objWriter->save('Reports.docx');
			} else {
				$objWriter->save('Reports.docx');
			}
		}
	}

	//Table function requested by bb gurl
	public function tableDocx($section, $tableHeaderName, $data, $keys)
	{
		//table element create
		$table = $section->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER]);

		$table->addRow();
		//table header
		foreach ($tableHeaderName as $headerName) {
			$table->addCell(1850, ['bgColor' => '022e43'])->addText($headerName, ['bold' => true, 'size' => 12, 'color' => 'FFFFFF'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
		}
		//table cell
		foreach ($data as $info) {
			$table->addRow();
			foreach ($keys as $key) {
				if ($key == 'name') {
					$name = str_replace(':', ' ', $info[$key]);
					$table->addCell(1200)->addText($name);
				} else {
					$table->addCell(1200)->addText($info[$key]);
				}
			}
		}
		$section->addPageBreak();
	}

	public function getColumnName($table, $count = 0)
	{
		$sql = "DESCRIBE `$table`";
		$result = $this->conn->query($sql);
		$tableHeaderName = array();
		$colCount = 0;
		while ($row = $result->fetch_assoc()) {
			$tableHeaderName[] = $row['Field'];
			$colCount++;
		}
		if ($count == 1) {
			return $colCount;
		}
		return $tableHeaderName;
	}

	//insert
	public function insertInfo($post, $tables, $id = true, $formArr = NULL)
	{
		$keys = array_keys($post);
		foreach ($tables as $table) {
			$tableHeaderName = $this->getColumnName($table);
			$colCount = $this->getColumnName($table, 1);
			$sql = "INSERT INTO $table(";
			$ctr = 0;
			if (!$id) {
				$ctr = 1;
			}

			//gets the column name and concats into sql query
			for (; $ctr < $colCount; $ctr++) {
				if ($ctr < $colCount - 1) {
					$sql .= "$tableHeaderName[$ctr], ";
				} else {
					$sql .= "$tableHeaderName[$ctr])";
				}
			}
			$sql .= " VALUES(";


			for ($i = 0, $j = 0; $j < $colCount; $i++) {
				if (strcmp($keys[$i], $tableHeaderName[$j]) == 0) {
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
			$this->conn->query($sql);
		}
	}

	//update
	public function updateInfo($post, $table, $condition, $primaryKey, $id = true, $formArr = NULL)
	{
		$keys = array_keys($post);
		for ($count = 0; $count < count($table); $count++) {
			$tableHeaderName = $this->getColumnName($table[$count]);
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
				if (strcmp($keys[$i], $tableHeaderName[$j]) == 0) {
					$value = $post[$keys[$i]];
					if (isset($formArr)) {
						$value = $post[$keys[$i]][$formArr];
					}
					if ($j < $colCount - 1) {
						//for those empty value
						if ($value == '') {
							$sql .= "$tableHeaderName[$j] = NULL, ";
							$j++;
						} else {
							$sql .= "$tableHeaderName[$j] = '$value', ";
							$j++;
						}
					} else {
						//for those empty value
						if ($value == '') {
							$sql .= "$tableHeaderName[$j] = NULL ";
							$j++;
						} else {
							$sql .= "$tableHeaderName[$j] = '$value' ";
							$j++;
						}
					}
				}
			}
			$sql .= "WHERE $condition = '$primaryKey'";
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
		if ($result->num_rows != 0) {
			return $result->num_rows;
		} else {
			return 0;
		}
	}
}

$conn = new connection();
$conn->mailer();
//feedback for the login
if (isset($_POST['type'])) {
	$id = $_POST['id'];
	$password = $_POST['password'];
	$result = $conn->find('logcredentials', "id = '$id'");
	$result += $conn->find('logcredentials', "id = '$id' and password ='$password'");
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
	}
}

if (isset($_POST['tableName'])) {
	$row = $conn->display($_POST['tableName']);
	echo json_encode($row);
}

$totalStudent = $conn->find('vaccinestatus', "id REGEXP '^[0-9]{1,2}-[0-9]{6,6}$'");
$totalFaculty = $conn->find('vaccinestatus', "id REGEXP '^F[0-9]{1,1}-[0-9]{6,6}$'");
//chart json 
//am i high when i did this? probably
//am i gonna change it? probably not
if (isset($_GET['chart'])) {
	switch ($_GET['chart']) {
		case 'firstAndSecond':
			$row = $conn->display('vacbrand');
			for ($i = 0; $i < count($row); $i++) {
				$brand[] = $row[$i]['brand'];
			}
			for ($i = 0; $i < count($row); $i++) {
				$value[] = $conn->find('vaccinestatus', "vacbrand = '$brand[$i]'");
			}
			$result = array_combine($brand, $value);
			echo json_encode($result);
			break;
		case 'booster':
			$row = $conn->display('vacbrand');
			for ($i = 0; $i < count($row); $i++) {
				$brand[] = $row[$i]['brand'];
			}
			for ($i = 0; $i < count($row); $i++) {
				$value[] = $conn->find('vaccinestatus', "boosterbrand = '$brand[$i]'");
			}
			$result = array_combine($brand, $value);
			echo json_encode($result);
			break;
		case 'firstDoseStudent':
			$key = ['First Dose Only', 'Total Student'];
			$value = array();
			array_push($value, $conn->find('vaccinestatus', "id REGEXP '^[0-9]{1,2}-[0-9]{6,6}$' and firstdose IS NOT NULL"));
			array_push($value, $totalStudent);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'firstDoseFaculty':
			$key = ['First Dose Only', 'Total Faculty'];
			$value = array();
			array_push($value, $conn->find('vaccinestatus', "id REGEXP '^F[0-9]{1,1}-[0-9]{6,6}$' and firstdose IS NOT NULL"));
			array_push($value, $totalFaculty);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'completeDoseStudent':
			$key = ['Complete Dose', 'Total Student'];
			$value = array();
			array_push($value, $conn->find('vaccinestatus', "id REGEXP '^[0-9]{1,2}-[0-9]{6,6}$' and seconddose IS NOT NULL"));
			array_push($value, $totalStudent);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'completeDoseFaculty':
			$key = ['Complete Dose', 'Total Faculty'];
			$value = array();
			array_push($value, $conn->find('vaccinestatus', "id REGEXP '^F[0-9]{1,1}-[0-9]{6,6}$' and seconddose IS NOT NULL"));
			array_push($value, $totalFaculty);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'boosterStudent':
			$key = ['Booster', 'Total Student'];
			$value = array();
			array_push($value, $conn->find('vaccinestatus', "id REGEXP '^[0-9]{1,2}-[0-9]{6,6}$' and booster IS NOT NULL"));
			array_push($value, $totalStudent);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'boosterFaculty':
			$key = ['Booster', 'Total Faculty'];
			$value = array();
			array_push($value, $conn->find('vaccinestatus', "id REGEXP '^F[0-9]{1,1}-[0-9]{6,6}$' and booster IS NOT NULL"));
			array_push($value, $totalFaculty);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
	}
}

//action respons
if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'submit':
			if (strcmp($_POST['table'], 'vacbrand') == 0) {
				$table = array($_POST['table']);
				$conn->insertInfo($_POST, $table);
			} else {
				$table = array($_POST['table'], 'vaccinestatus', 'logcredentials');
				$conn->insertInfo($_POST, $table);
				$conn->sendMail('sendCredentials', $_POST['id'], $_POST['password'], $_POST['email']);
			}
			break;
		case 'update':
			$table = array($_POST['table'], 'vaccinestatus', 'logcredentials');
			$conn->updateInfo($_POST, $table, 'id', $_POST['condition']);
			if (strcmp($_POST['id'], $_POST['condition']) != 0) {
				//$conn->sendMail('updatedID', $_POST['id']);
			}
			break;
		case 'delete':
			break;
	}
}
