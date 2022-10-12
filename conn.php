<?php
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
}
?>