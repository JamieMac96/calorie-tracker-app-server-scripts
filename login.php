
<?php
    include('DatabaseHelper.class.php');
    $db = new DatabaseHelper();
    $db -> connect();
    if(isset($_POST['email']) && isset($_POST["password"])){
      $email = $db -> quote($_POST['email']);
      $password = $db->quote($_POST["password"]);
      $sqlSelect = "SELECT * FROM User WHERE EmailAddress = '$email';";
      $result = $db -> select($sqlSelect);

      $colPassword = $result[0]['Password'];

      $response = array();

      $response["success"] = false;

      if(password_verify($password, $colPassword)) {
        $response["success"] = true;
        $response["UserID"] = $result[0]["UserID"];
        echo  json_encode($response, JSON_FORCE_OBJECT);
      }
      else{
  	     echo "{'success': false}";
      }
    }
    else{
      echo "{'success': false}";
    }
?>
