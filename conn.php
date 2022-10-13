<?php
include('sqlcommands.php');


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
		$sql = "DELETE FROM info WHERE id = $id";
		$result = $this->conn->query($sql);
		if($result)
		{
			header('location:home.php');
		}
		else
		{
			echo "ERROR" .$sql ."<br>". $this->conn->server;
		}
	}
}
