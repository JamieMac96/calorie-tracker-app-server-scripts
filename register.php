<?php 
    include('DatabaseHelper.class.php');
    $db = new DatabaseHelper();
    $connection = $db -> connect();
    if($connection){
      $email = $db -> quote($_POST["email"]);
      $password = $db -> quote($_POST["password"]);

       function registerUser() {
          global $email, $password, $db;
          $passwordHash = password_hash($password, PASSWORD_DEFAULT);
          $sql = "INSERT INTO User (UserID, EmailAddress, Password) VALUES ('0', '$email', '$passwordHash');";
          $result = $db -> query($sql);
          if($result){
            return true;
          }
          else{
            return false;
          }
      }
      function emailAvailable() {
          global $email, $db, $password;
          $sqlSelect = "SELECT * FROM User WHERE EmailAddress = '$email' AND Password = '$password';"; 
          $result = $db -> select($sqlSelect);
          if(!$result){
            return true;
          }
      }
      $response = array();
      $response["success"] = false;
      if (emailAvailable()){
          if(registerUser()){
            $response["success"] = true;
  	    $response["UserID"] = $db -> getLastInsertID();
          }
      }
      echo json_encode($response);
    }
    else{
      $response["success"] = false;
      echo json_encode($response);
    }
?>
