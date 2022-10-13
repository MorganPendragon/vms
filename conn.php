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

	public function insertInfo($post)
	{
		$name = $post['firstName'] .' ' .$post['middleName'] .' ' .$post['lastName'];
		$gender = $post['gender'];
		$birthday = $post['date'];
		$email = $post['email'];
		$address = $post['address'];
		$tel = $post['tel'];
		$sql = "INSERT INTO info(name, gender, birthday, email, address, tel) VALUES('$name', '$gender','$birthday', '$email', '$address', '$tel')";
		if($this->conn->query($sql))
		{
			header('location:adminview.php');
		}
		else
		{
			echo "Error" .$sql ."<br>" .$this->conn->error;
		}
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
}