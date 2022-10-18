<?php
//TODO:Refactor docx generation and redirect the file path to somewhere else

//autoloader cause lazy
require __DIR__.'/vendor/autoload.php';
//calls the lib
use PhpOffice\PhpWord\Shared\Converter;
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

	public function getData($table, $column)
	{
		$sql = "SELECT $column FROM $table";
		$result = $this->conn->query($sql);
		while($row = $result->fetch_assoc())
		{
			$data[] = $row;
		}
		return $data;
	}

	//insert
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
				//for those empty value
				if($value == '')
				{
					$sql .="NULL, ";
				}
				else
				{
					$sql .="'$value', ";
				}
			}
			else
			{
				//for those empty value
				if($value == '')
				{
					$sql .="NULL)";
				}
				else
				{
					$sql .="'$value')";
				}
			}
			$ctr++;
		}
		if($this->conn->query($sql))
		{
			header('location:adminview.php');
		}
	}

	//update
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
				//for those empty value
				if($value == '')
				{
					$sql .= "$colName[$j] = NULL, ";
					$j++;
				}
				else
				{
					$sql .= "$colName[$j] = '$value', ";
					$j++;
				}
			}
			else
			{
				//for those empty value
				if($value == '')
				{
					$sql .= "$colName[$j] = NULL ";
					$j++;
				}
				else
				{
					$sql .= "$colName[$j] = '$value' ";
					$j++;
				}
			}
		}

		$sql .= "WHERE $condition = '$primaryKey'";
		
		if($this->conn->query($sql))
		{
			header('location:adminview.php');
		}
	}

	//delete
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

		$GLOBALS['phpWord']->addTitleStyle(2, ['size' => 14, 'bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100]);

		$section = $GLOBALS['phpWord']->addSection(['colsNum' => 1], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100]);
		//chart legends
		$categories = array('First Dose only', 'First and Second');
		$series = array();

		//chart data
		$series[] = $this->find('student', 'firstdose IS NOT NULL and seconddose IS NULL');
		$series[] = $this->find('student', 'firstdose IS NOT NULL and seconddose IS NOT NULL');

		//chart creation
		$section->addTitle(ucfirst('Student'), 2);
		$chart = $section->addChart('pie', $categories, $series);
		$chart->getStyle()->setShowLegend(true);
		$chart->getStyle()->setLegendPosition('b');
		$chart->getStyle()->setWidth(Converter::inchToEmu(5))->setHeight(Converter::inchToEmu(5));

		// Saving the document as DOCX file...
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($GLOBALS['phpWord'], 'Word2007');
		$objWriter->save('StudentReport.docx');
		header('location:adminview.php');
	}
}