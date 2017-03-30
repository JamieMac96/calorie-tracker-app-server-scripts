
<?php





    include('DatabaseHelper.class.php');
    $db = new DatabaseHelper();
    $db -> connect();
    $email = $_POST["email"];
    $password = $_POST["password"];
    $sqlSelect = "SELECT * FROM User WHERE EmailAddress = '$email';";
    $result = $db -> select($sqlSelect);
	
    $colPassword = $result[0]['Password'];
    $response = array();
  
    $response["success"] = false;
    
    if(password_verify($password, $colPassword)) {
      $response["success"] = true;
      $response["UserID"] = $result[0]["UserID"];
    }
    $jsonReturn =  json_encode($response, JSON_FORCE_OBJECT);

    if($jsonReturn){
	echo $jsonReturn;
    }
    else{
	echo "{'success': false}";
    }
?>

