<?php
//TODO:Refactor docx generation and redirect the file path to somewhere else

//autoloader cause lazy
require __DIR__ . '/vendor/autoload.php';
//key passphrase for the encryption
$key = 'oceansofknowledge';
$cipher = 'aes-128-gcm';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

use function PHPSTORM_META\argumentsSet;

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

	public function mailer()
	{
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

	public function sendMail($action, $contents)
	{
		switch ($action) {
			case 'sendCredentials':
				$message = file_get_contents('./email/logincredentials.html');
				$message = str_replace('%idNo%', $contents[0], $message);
				$message = str_replace('%password%', $contents[1], $message);
				$this->mail->Subject = 'Log In Credentials';
				$this->mail->AddEmbeddedImage('./img/logo.png', 'logo');
				$this->mail->isHTML(true);
				$this->mail->msgHTML($message);
				$this->mail->addAddress($contents[2]);
				$this->mail->send();
				break;
			case 'updatedId':
				$message = file_get_contents('./email/updatedId.html');
				$message = str_replace('%idNo%', $contents[0], $message);
				$this->mail->Subject = 'Your ID has been Updated by the Administrator';
				$this->mail->addEmbeddedImage('./img/logo.png', 'logo');
				$this->mail->isHTML(true);
				$this->mail->msgHTML($message);
				$this->mail->addAddress($contents[1]);
				$this->mail->send();
				break;
			case 'twoFactor':
				$message = file_get_contents('./email/idcredentials.html');
				$message = str_replace('%idNo%', $contents[0], $message);
				$this->mail->Subject = 'Your ID has been Updated by the Administrator';
				$this->mail->addEmbeddedImage('./img/logo.png', 'logo');
				$this->mail->isHTML(true);
				$this->mail->msgHTML($message);
				$this->mail->addAddress($contents[1]);
				$this->mail->send();
				break;
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
		if ($name == 'report') {
			$post = $arguments[0];
			$phpWord = new \PhpOffice\PhpWord\PhpWord();
			$section = $phpWord->addSection(['breakType' => 'continous']);

			$headerFontStyle = ['size' => 16, 'bold' => true];
			//chart for vaccine manufacturer on first, second and booster
			$title = ['Vaccine Manufacturer for First and Second', 'Vaccine Manufacturer for Booster'];
			$conditions = ['vacbrand', 'boosterbrand'];
			$brands = $this->display('*', 'vacbrand');
			$i = 0;
			$table = $section->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'borderColor' => 'FFFFFF']);
			$table->addRow(5000);
			foreach ($conditions as $condition) {
				$series = array();
				$categories = array();

				$chartStyle = [
					'LegendPostion' => 'b',
					'title' => $title[$i],
					'width' => Converter::inchToEmu(3),
					'height' => Converter::inchToEmu(4),
					'colors' => ['3A557A', '90B7CD', 'D4EEEE', 'F2AE08', 'E26749', 'ED7E00'],
				];

				foreach ($brands as $key) {
					$temp = $key['brand'];
					array_push($categories, $temp);
					array_push($series, $this->find('vaccinestatus', "$condition = '$temp'"));
				}
				$table->addCell(5000)->addChart('pie', $categories, $series, $chartStyle);
				$i++;
			}
			//chart for vaccine status
			$title = ['Not Vaccinated', 'First Dose Only', 'Completed', 'Booster'];
			$total = [
				$this->find('vaccinestatus', "id REGEXP '^[0-9]{1,2}-[0-9]{6,6}$'"),
				$this->find('vaccinestatus', "id REGEXP '^F[0-9]{1,1}-[0-9]{6,6}$'")
			];

			$chartTitle = ['Student', 'Faculty'];
			$regex = ['^[0-9]{1,2}-[0-9]{6,6}$', '^F[0-9]{1,1}-[0-9]{6,6}$'];
			$conditions = [
				'firstdose IS NULL and seconddose IS NULL', 'firstdose IS NOT NULL',
				'seconddose IS NOT NULL', 'booster IS NOT NULL'
			];
			$i = 0;
			foreach ($conditions as $condition) {
				$section->addText($title[$i], $headerFontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
				$table = $section->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'borderColor' => 'FFFFFF']);
				$table->addRow(5000);
				$j = 0;
				foreach ($chartTitle as $charttitle) {
					$count = $this->find('vaccinestatus', "id REGEXP'$regex[$j]' and $condition");
					$series = [$count, $total[$j] - $count];
					$chartStyle = [
						'LegendPostion' => 'b',
						'title' => $charttitle,
						'width' => Converter::inchToEmu(3),
						'height' => Converter::inchToEmu(4),
						'colors' => ['3A557A', '90B7CD', 'D4EEEE', 'F2AE08', 'E26749', 'ED7E00'],
					];
					$categories = ['No. of ' . $charttitle . ' with ' . $title[$i], 'Total No. of ' . $charttitle];
					$table->addCell(5000)->addChart('pie', $categories, $series, $chartStyle);
					$j++;
				}
				$i++;
			}
			//TODO:table data
			if ($post['table'] != '') {
				$section = $phpWord->addSection(['orientation' => 'landscape']);
				if ($post['student'] != '') {
					$condition = '';
					//filter
					if ($post['yearLevel'] != '') {
						$temp = $post['yearLevel'];
						$condition .= "yearLevel = '$temp'";
					}
					if ($post['vacbrand'][0] != '') {
						$temp = $post['vacbrand'][0];
						$condition .= " and vacbrand = '$temp'";
					}
					if ($post['boosterbrand'][0] != '') {
						$temp = $post['boosterbrand'][0];
						$condition .= " and boosterbrand = '$temp'";
					}

					$section->addText('Student', $headerFontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
					//student
					$tableHeaderName = ['ID', 'Name', 'Gender', 'Year Level', 'First Dose', 'Second Dose', 'Vaccine Manufacturer', 'Booster', 'Booster Manufacturer'];
					//keys for the data
					$keys = ['id', 'name', 'gender', 'yearLevel', 'firstdose', 'seconddose', 'vacbrand', 'booster', 'boosterbrand'];
					//table header
					if ($condition != '') {
						$data = $this->display('*', 'student INNER JOIN vaccinestatus ON student.id = vaccinestatus.id', $condition);
					}
					$this->tableDocx($section, $tableHeaderName, $data, $keys);
				}

				if ($post['faculty'] != '') {
					//filter
					$condition = '';
					if ($post['vacbrand'][1] != '' && isset($post['vacbrand'][1])) {
						$temp = $post['vacbrand'][1];
						$condition .= "vacbrand = '$temp'";
					}
					if ($post['boosterbrand'][1] != '') {
						$temp = $post['booster'][1];
						$condition .= "and boosterbrand = '$temp'";
					}

					$section->addText('Faculty', $headerFontStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
					//faculty
					$tableHeaderName = ['ID', 'Name', 'Gender', 'First Dose', 'Second Dose', 'Vaccine Manufacturer', 'Booster', 'Booster Manufacturer'];
					//keys for the data
					$keys = ['id', 'name', 'gender', 'firstdose', 'seconddose', 'vacbrand', 'booster', 'boosterbrand'];
					//table header
					if ($condition != '') {
						$data = $this->display('*', 'faculty INNER JOIN vaccinestatus ON faculty.id = vaccinestatus.id', $condition);
					}
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
		//password encryption
		if (isset($post['password'])) {
			//encryption type which is aes-128 galois/counter mode
			$id = $post['id'];
			//generate iv
			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($GLOBALS['cipher']));
			$iv = bin2hex($iv);
			if (in_array($GLOBALS['cipher'], openssl_get_cipher_methods())) {
				$post['password'] = openssl_encrypt($post['password'], $GLOBALS['cipher'], $GLOBALS['key'], $options = 0, $iv, $tag);
				$sql = "INSERT INTO cipher VALUES('$id', '$iv', '$tag')";
				$this->conn->query($sql);
			}
		}

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

			if ($count >= 2) {
				$colCount = 1;
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
echo $original_plaintext . "\n";

//feedback for the login
if (isset($_POST['type'])) {
	$id = $_POST['id'];
	$password = $_POST['password'];
	$result = $conn->find('logcredentials', "id = '$id'");
	if($result == 1)
	{
		$salt = $conn->display('*', "cipher INNER JOIN logcredentials on cipher.id = logcredentials.id", "logcredentials.id='$id'");
		$decryptedPass = openssl_decrypt($info[0]['password'], $GLOBALS['cipher'], $GLOBALS['key'], $options = 0, $info[0]['iv'], $info[0]['tag']);
		if(strcmp($password, $decryptedPass)== 0)
		{
			$result++;
		}
	}
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
	$row = $conn->display('*', $_POST['tableName']);
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
			$row = $conn->display('*', 'vacbrand');
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
			$row = $conn->display('*', 'vacbrand');
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
			$count = $conn->find('vaccinestatus', "id REGEXP '^[0-9]{1,2}-[0-9]{6,6}$' and firstdose IS NOT NULL");
			$key = ['First Dose Only', 'Total Student'];
			$value = array();
			array_push($value, $count);
			array_push($value, $totalStudent - $count);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'firstDoseFaculty':
			$count = $conn->find('vaccinestatus', "id REGEXP '^F[0-9]{1,1}-[0-9]{6,6}$' and firstdose IS NOT NULL");
			$key = ['First Dose Only', 'Total Faculty'];
			$value = array();
			array_push($value, $count);
			array_push($value, $totalFaculty - $count);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'completeDoseStudent':
			$count = $conn->find('vaccinestatus', "id REGEXP '^[0-9]{1,2}-[0-9]{6,6}$' and seconddose IS NOT NULL");
			$key = ['Complete Dose', 'Total Student'];
			$value = array();
			array_push($value, $count);
			array_push($value, $totalStudent - $count);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'completeDoseFaculty':
			$count = $conn->find('vaccinestatus', "id REGEXP '^F[0-9]{1,1}-[0-9]{6,6}$' and seconddose IS NOT NULL");
			$key = ['Complete Dose', 'Total Faculty'];
			$value = array();
			array_push($value, $count);
			array_push($value, $totalFaculty - $count);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'boosterStudent':
			$count = $conn->find('vaccinestatus', "id REGEXP '^[0-9]{1,2}-[0-9]{6,6}$' and booster IS NOT NULL");
			$key = ['Booster', 'Total Student'];
			$value = array();
			array_push($value, $count);
			array_push($value, $totalStudent - $count);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
		case 'boosterFaculty':
			$conn->find('vaccinestatus', "id REGEXP '^F[0-9]{1,1}-[0-9]{6,6}$' and booster IS NOT NULL");
			$key = ['Booster', 'Total Faculty'];
			$value = array();
			array_push($value, $count);
			array_push($value, $totalFaculty - $count);
			$result = array_combine($key, $value);
			echo json_encode($result);
			break;
	}
}

//action response
if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'submit':
			if (strcmp($_POST['table'], 'vacbrand') == 0) {
				$table = array($_POST['table']);
				$conn->insertInfo($_POST, $table);
			} else {
				$table = array($_POST['table'], 'vaccinestatus', 'logcredentials');
				$conn->insertInfo($_POST, $table);
				$conn->sendMail('sendCredentials', [$_POST['id'], $_POST['password'], $_POST['email']]);
			}
			break;
		case 'update':
			if (strcmp($_POST['table'], 'vacbrand') == 0) {
				$table = array($_POST['table']);
				$conn->updateInfo($_POST, $table, 'brand', $_POST['condition']);
			} else {
				$table = array($_POST['table'], 'vaccinestatus', 'logcredentials', 'cipher');
				$conn->updateInfo($_POST, $table, 'id', $_POST['condition']);
				if (strcmp($_POST['id'], $_POST['condition']) != 0) {
					$conn->sendMail('updatedID', [$_POST['id'], $_POST['email']]);
				}
			}
			break;
		case 'delete':
			if (strcmp($_POST['table'], 'vacbrand') == 0) {
				$table = array($_POST['table']);
				$conn->deleteInfo($table, 'brand', $_POST['delete']);
			} else {
				$table = array($_POST['table'], 'vaccinestatus', 'logcredentials', 'cipher');
				$conn->deleteInfo($table, 'id', $_POST['delete']);
			}
			break;
		case 'report':
			$conn->report($_POST);
			break;
	}
}
