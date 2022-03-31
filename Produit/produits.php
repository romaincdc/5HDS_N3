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
	function getProducts()
	{
		global $conn;
		$query = "SELECT * FROM produit";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getProduct($id=0)
	{
		global $conn;
		$query = "SELECT * FROM produit";
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
	
	
	
    function AddProduct()
    {
      global $conn;
      $name = $_POST["nom"];
		$description = $_POST["description"];
        $token = randomToken(10);
		$price = $_POST["prix"];
        $stock = $_POST["stock"];
		$reference = $_POST["reference"];
		$created = date('Y-m-d H:i:s');
		$modified = date('Y-m-d H:i:s');
      echo $query="INSERT INTO produit(nom, description,token, prix,stock, reference, created_at, update_at) VALUES('".$name."', '".$description."', '".$token."','".$price."', '".$stock."', '".$reference."', '".$created."', '".$modified."')";
      if(mysqli_query($conn, $query))
      {
        $response=array(
          'status' => 1,
          'status_message' =>'Produit ajoute avec succes.'
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
	function updateProduct($id)
	{
		global $conn;
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
        
		$name = $_PUT["name"];
		$description = $_PUT["description"];
        $token = randomToken(10);
		$price = $_PUT["price"];
        $stock = $_PUT["stock"];
		$reference = $_PUT["reference"];
		$created = 'NULL';
		$modified = date('Y-m-d H:i:s');
		$query="UPDATE produit SET nom='".$name."', description='".$description."', token='".$token."', prix='".$price."', stock='".$stock."', reference='".$reference."', update_at='".$modified."' WHERE id=".$id;
		
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Produit mis a jour avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Echec de la mise a jour de produit. '. mysqli_error($conn)
			);
			
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function deleteProduct($id)
	{
		global $conn;
		$query = "DELETE FROM produit WHERE id=".$id;
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Produit supprime avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'La suppression du produit a echoue. '. mysqli_error($conn)
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
				getProduct($id);
			}
			else
			{
				getProducts();
			}
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
			
		case 'POST':
			// Ajouter un produit
			AddProduct();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
            
			updateProduct($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteProduct($id);
			break;

	}
?>