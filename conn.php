<?php
//TODO:Refactor docx generation and redirect the file path to somewhere else

//autoloader cause lazy
require __DIR__.'/vendor/autoload.php';
//calls the lib
$phpWord = new \PhpOffice\PhpWord\PhpWord();

class vaccination
{
    private $servername = 'localhost';
	private $username = 'j';
	private $password = 'password';
	private $dbname = 'Vaccine';
	private $conn;
	
    function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		if ($this->conn->connect_error) 
		{
			echo 'Connection Failed';
		} 
		else 
		{
			return $this->conn;
		}
    }

	public function displayTable($table)
	{
		$sql = "SELECT * FROM $table";
		$result = $this->conn->query($sql);
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	public function displayRowByID($table, $col, $id)
	{
		$sql = "SELECT * FROM $table WHERE $col = $id";
		$result = $this->conn->query($sql);
		if ($result->num_rows == 1) 
		{
			$row = $result->fetch_assoc();
			return $row;
		}
	}

	public function getColumnName($table)
	{
		$sql = "DESCRIBE `$table`";
		$result = $this->conn->query($sql);
		$colName = array();
		while($row = $result->fetch_assoc())
		{
			$colName[] = $row['Field'];
		}
		return $colName;
	}

	public function insertInfo($post, $table)
	{
		$colName = $this->getColumnName($table);
		$ctr = 1;
		$keys = array_keys($post);
		$sql = "INSERT INTO $table(";
		foreach($colName as $col)
		{
			if($ctr < count($colName))
			{
				$sql .= "$col, ";
			}
			else
			{
				$sql .="$col)";
			}
			$ctr++;
		}
		$sql .= " VALUES(";
		$ctr = 1;
		foreach($keys as $key)
		{
			$value = $post["$key"];
			if($key == 'firstName' || $key == 'middleName')
			{
				$sql .= "$value ";
			}
			elseif($key == 'lastName')
			{
				$sql .= "$value, ";
			}
			elseif($ctr < count($keys))
			{
				$sql .="$value, ";
			}
			else
			{
				$sql .="$value)";
			}
			$ctr++;
		}
		print_r($keys); 
		echo '</br>';
		return $sql;

	}

	public function insertVac($post)
	{
		$name = $post['brandName'];
		$sql="INSERT INTO vacBrand(brand) VALUES('$name')";
		if($this->conn->query($sql))
		{
			header('location:adminview.php');
		}
		else
		{
			echo "Error" .$sql ."<br>" .$this->conn->error;
		}
	}
	//TODO:Redo this Update Function
	public function updateInfo($post ,$id)
	{
		$name = $post['upFirstName'] .' ' .$post['upMiddleName'] .' ' .$post['upLastName'];
		$gender = $post['upGender'];
		$birthday = $post['upDate'];
		$email = $post['upEmail'];
		$address = $post['upAddress'];
		$tel = $post['upTel'];
		$sql = "UPDATE info SET name='$name', gender='$gender',birthday='$birthday', email='$email', address='$address', tel='$tel' WHERE id=$id";
		
		if($this->conn->query($sql))
		{
			header('location:adminview.php');
		}
		else
		{
			echo "Error" .$sql ."<br>" .$this->conn->error;
		}
	}

	public function updateVac($post, $id)
	{
		$name=$post['brandName'];
		$sql = "UPDATE vacBrand SET brand='$name' WHERE id=$id";

		if($this->conn->query($sql))
		{
			header('location:adminview.php');
		}
		else
		{
			echo "Error" .$sql ."<br>" .$this->conn->error;
		}
	}


	public function deleteInfo($table, $col, $id)
	{
		$sql = "DELETE FROM $table WHERE $col = $id";
		$result = $this->conn->query($sql);
		if($result)
		{
			header('location:adminview.php');
		}
		else
		{
			echo "ERROR" .$sql ."<br>". $this->conn->server;
		}
	}

	public function studentReport()
	{
		$section = $GLOBALS['phpWord']->addSection();
		// Adding Text element to the Section having font styled by default...
		$section->addText(
			'"Learn from yesterday, live for today, hope for tomorrow. '
			. 'The important thing is not to stop questioning." '
			. '(Albert Einstein)'
		);

		// Saving the document as OOXML file...
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($GLOBALS['phpWord'], 'Word2007');
		$objWriter->save('StudentReport.docx');
		header('location:adminview.php');
	}
}