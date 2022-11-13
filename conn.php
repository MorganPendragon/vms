<?php
//TODO:Refactor docx generation and redirect the file path to somewhere else

//autoloader cause lazy
require __DIR__.'/vendor/autoload.php';
//calls the lib
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
		$sql = "SELECT * FROM $table WHERE $col = '$id'";
		$result = $this->conn->query($sql);
		if ($result->num_rows == 1) 
		{
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
		while($row = $result->fetch_assoc())
		{
			$colName[] = $row['Field'];
			$colCount++;
		}
		if($count == 1)
		{
			return $colCount;
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
	public function insertInfo($post, $table, $id=true, $formArr = NULL)
	{
		$keys = array_keys($post);
		print_r($keys);
		echo count($table);
		for($count = 0; $count < count($table); $count++)
		{
			$colName = $this->getColumnName($table[$count]);
			$colCount = $this->getColumnName($table[$count], 1);
			$sql = "INSERT INTO $table[$count](";
			$ctr = 0;
			if(!$id)
			{
				$ctr = 1;
			}

			//gets the column name and concats into sql query
			for(;$ctr < $colCount;$ctr++)
			{
				if($ctr < $colCount-1)
				{
					$sql .= "$colName[$ctr], ";
				}
				else
				{
					$sql .="$colName[$ctr])";
				}
			}
			$sql .= " VALUES(";


			for($i = 0, $j = 0;$j < $colCount; $i++)
			{
				if(strcmp($keys[$i], $colName[$j]) == 0)
				{
					$value = $post[$keys[$i]];
					if(isset($formArr))
					{
						$value = $post[$keys[$i]][$formArr];
					}
					if($j < $colCount - 1)
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
					$j++;
				}
			}
			echo $sql . "\n";
			$this->conn->query($sql);
		}
	}

	//update
	public function updateInfo($post, $table, $condition, $primaryKey, $id=true, $formArr = NULL)
	{
		$keys = array_keys($post);
		print_r($keys);
		for($count = 0; $count < count($table);$count++)
		{
			$colName = $this->getColumnName($table[$count]);
			$colCount = $this->getColumnName($table[$count], 1);
			$sql = "UPDATE $table[$count] SET ";
			$j = 0;

			if(!($id))
			{
				$j = 1;
			}
			for($i = 0; $i < count($keys); $i++)
			{
				if(strcmp($keys[$i], $colName[$j]) == 0)
				{
					$value = $post[$keys[$i]];
					if(isset($formArr))
					{
						$value = $post[$keys[$i]][$formArr];
					}
					if($j < $colCount - 1)
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
			}
			$sql .= "WHERE $condition[$count] = '$primaryKey'";
			echo $sql;
			$this->conn->query($sql);
		}
	}

	//delete
	public function deleteInfo($table, $col, $id)
	{
		for($i = 0; $i < count($table); $i++)
		{
			$sql = "DELETE FROM $table[$i] WHERE $col[$i] = '$id'";
			$this->conn->query($sql);	
		}
	}

	public function find($table, $condition)
	{
		$sql = "SELECT * FROM $table WHERE $condition";
		$result = $this->conn->query($sql);
		return $result->num_rows;
	}

	public function imageHandler($post)
	{
		$post['vaccineStudent'];
	}

	//report generation using PHPOffice
	public function report()
	{
		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		//font style for texts
		$fStyle = [
			'bold'=>true
		];
		$section = $phpWord->addSection();
		$section->addText('No. of Vaccinated', $fStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
		$table = ['student', 'faculty'];		
		$header = $section->addHeader();
		
		//header content
		$header->addText(date('m/d/Y'),$fStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);
		//chart legends
		$categories = array('First Dose only', 'First and Second');
		$series = array();
		$i = 0;
		foreach($table as $tableName)
		{
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
		foreach($table as $tableName)
		{
			foreach($brand as $brandName)
			{
				$categories[] = $brandName['brand'];
				$temp = $brandName['brand'];
				$series[]= $this->find($tableName, "brand = '$temp'");
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