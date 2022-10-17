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

	public function insertInfo($post, $table, $id=true, $formArr=0)
	{
		$colName = $this->getColumnName($table);
		$keys = array_keys($post);
		$sql = "INSERT INTO $table(";
		$ctr = 0;
		if(!$id)
		{
			$ctr = 1;
		}
		for(;$ctr < count($colName);$ctr++)
		{
			if($ctr < count($colName)-1)
			{
				$sql .= "$colName[$ctr], ";
			}
			else
			{
				$sql .="$colName[$ctr])";
			}
		}
		$sql .= " VALUES(";
		$ctr = 1;
		foreach($keys as $key)
		{
			if(isset($formArr))
			{
				$value = $post[$key][$formArr];
			}
			else
			{
				$value = $post[$key];
			}
			if($key == 'firstName')
			{
				$sql .= "'$value ";
			}
			elseif($key == 'middleName')
			{
				$sql .= "$value ";
			}
			elseif($key == 'lastName')
			{
				$sql .= "$value', ";
			}
			elseif($ctr < count($keys))
			{
				$sql .="'$value', ";
			}
			else
			{
				$sql .="'$value')";
			}
			$ctr++;
		}
		echo $sql;
		print_r($keys); 
		echo '</br>';
	}

	public function insertWithoutID($post, $table)
	{
		$colName = $this->getColumnName($table);
		$keys = array_keys($post);
		$sql = "INSERT INTO $table(";
		for($i = 1; $i < count($colName); $i++)
		{
			if($i < count($colName))
			{
				$sql .= "$colName[$i], ";
			}
			else
			{
				$sql .="$colName[$i])";
			}
		}

		echo $sql;
	}

	//TODO:Redo this Update Function
	public function updateInfo($post, $table, $update, $id)
	{
		$keys = array_keys($post);
		$colName = $this->getColumnName($table);
		$sql = "UPDATE info SET ";
		$value=0;
		for($i = 0; $i < count($colName);)
		{
			$key = $keys[$i];
			$value = $post[$key][0];
			$sql .= "$colName[$i]= ";
		}
		echo $sql;
		print_r(array_keys($post));
		echo '</br>'. $sql;
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
		$sql = "DELETE FROM $table WHERE $col = '$id'";
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