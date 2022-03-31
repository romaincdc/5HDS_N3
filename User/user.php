<?php
	// Connect to database
	include("../db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

    function randomToken($car) {
        $string = "";
        $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqr stuvwxyz";
        srand ( ( double ) microtime () * 1000000 ); for($i = 0; $i < $car; $i ++) {
        $string .= $chaine [rand () % strlen ( $chaine )]; }
        return $string;
        }
	function getUsers()
	{
		global $conn;
		$query = "SELECT * FROM users";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getUser($id=0)
	{
		global $conn;
		$query = "SELECT * FROM users";
		if($id != 0)
		{
			$query .= " WHERE id=".$id." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function AddUser()
	{
		global $conn;
		$name = $_POST["nom"];
		$prenom = $_POST["prenom"];
        $token = randomToken(10);
		$role = $_POST["role"];
		$created = date('Y-m-d H:i:s');
		$modified = date('Y-m-d H:i:s');
		echo $query="INSERT INTO users(nom, prenom,token, role , created_at, update_at) VALUES('".$name."', '".$prenom."', '".$token."','".$role."', '".$created."', '".$modified."')";
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'user ajoute avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'ERREUR!.'. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function updateUser($id)
	{
		global $conn;
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
        
		$name = $_PUT["nom"];
		$prenom = $_PUT["prenom"];
        $token = randomToken(10);
		$role = $_PUT["role"];
		$created = 'NULL';
		$modified = date('Y-m-d H:i:s');
		$query="UPDATE users SET nom='".$name."', prenom='".$prenom."', token='".$token."', role='".$role."', update_at='".$modified."' WHERE id=".$id;
		
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'User mis a jour avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Echec de la mise a jour de user. '. mysqli_error($conn)
			);
			
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function deleteUser($id)
	{
		global $conn;
		$query = "DELETE FROM users WHERE id=".$id;
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'User supprime avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'La suppression de user a echoue. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	switch($request_method)
	{
		
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				getUser($id);
			}
			else
			{
				getUsers();
			}
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
			
		case 'POST':
			// Ajouter un produit
			AddUser();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
            
			updateUser($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteUser($id);
			break;

	}
?>