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

	public function __call($name, $arguments)
	{
		if ($name == 'display') {
			switch (count($arguments)) {
				case 1:
					$sql = "SELECT * FROM $arguments[0]";
					$result = $this->conn->query($sql);
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$data[] = $row;
						}
						return $data;
					} else {
						return $data = array();
					}
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
					$sql = "SELECT * FROM $arguments[0] WHERE $arguments[1] = '$arguments[2]'";
					$result = $this->conn->query($sql);
					if ($result->num_rows != 0) {
						$row = $result->fetch_assoc();
						return $row;
					}
				case 4:
					$sql = "SELECT * FROM $arguments[0] WHERE $arguments[1] = '$arguments[2]'";
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

	//insert
	public function insertInfo($post, $table, $id = true, $formArr = NULL)
	{
		$keys = array_keys($post);
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
		if ($result->num_rows != 0) {
			return $result->num_rows;
		} else {
			return 0;
		}
	}

	//TODO:Report filter and update this BS
	//report generation using PHPOffice
	public function report()
	{
		$phpWord = new \PhpOffice\PhpWord\PhpWord();
	}
}

$conn = new connection();
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
	} else {
		echo 'Upload unsuccessful';
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

if(isset($_POST['action']))
{
	switch($_POST['action'])
	{
		case 'submit':
			$table = array($_POST['table'], 'vaccinestatus', 'logcredentials');
			$conn->insertInfo($_POST, $table);
			break;
		case 'update':
			break;
		case 'delete':
			break;
	}
}