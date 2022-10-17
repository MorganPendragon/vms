<?php
//TODO:Refactor docx generation and redirect the file path to somewhere else

//autoloader cause lazy
require __DIR__.'/vendor/autoload.php';
//calls the lib
$phpWord = new \PhpOffice\PhpWord\PhpWord();

class connection
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

		//gets the column name and concats into sql query
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

		//assigns the column name to their respective values
		foreach($keys as $key)
		{
			$value = $post[$key];
			if(isset($formArr))
			{
				$value = $post[$key][$formArr];
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
	public function updateInfo($post, $table, $condition, $primaryKey,$id=true, $formArr = 0)
	{
		$keys = array_keys($post);
		$colName = $this->getColumnName($table);
		$sql = "UPDATE $table SET ";
		$value=0;
		$j = 0;

		if(!$id)
		{
			$j = 1;
		}
		//assigns the column name to their respective values
		for($i = 0;$i < count($keys);$i++)
		{
			$value = $post[$keys[$i]];
			if(isset($formArr))
			{
				$value = $post[$keys[$i]][$formArr];
			}

			if($keys[$i] == 'upFirstName')
			{
				$sql .= "$colName[$j] = '$value ";
				$j++;
			}
			elseif($keys[$i] == 'upMiddleName')
			{
				$sql .= "$value ";
			}
			elseif($keys[$i] == 'upLastName')
			{
				$sql .= "$value', ";
			}
			elseif($i < count($keys) -1)
			{
				$sql .= "$colName[$j] = '$value', ";
				$j++;
			}
			else
			{
				$sql .= "$colName[$j] = '$value' ";
				$j++;
			}
		}

		$sql .= "WHERE $condition = '$primaryKey'";
		
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