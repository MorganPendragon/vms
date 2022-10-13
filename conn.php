<?php

function showTable($table)
{
	return "SELECT * FROM $table";
}

function deleteRow($table, $col, $id)
{
	return "DELETE FROM $table WHERE $col = $id";
}

function showInfoByID($table, $col, $id)
{
	return "SELECT * FROM $table WHERE $col = $id";
}

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

	public function displayInfo()
	{
		$sql = showTable('info');
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

	public function updateInfo($id)
	{

	}

	public function deleteInfo($id)
	{
		$sql = deleteRow('info', 'id', $id);
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
}