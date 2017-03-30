<?php

  include_once("DatabaseHelper.class.php");

  $db = new DatabaseHelper();
  $connection = $db -> connect();
 
  $response = array();
  $response["success"] = false;

  if($connection){
    $name = $db -> quote($_POST['Name']);
    $desc = $db -> quote($_POST['Description']);
    $servingSize = $db -> quote($_POST['ServingSize']);
    $fatPerServing = $db -> quote($_POST['FatPerServing']);
    $carbsPerServing = $db -> quote($_POST['CarbsPerServing']);
    $proteinPerServing = $db -> quote($_POST['ProteinPerServing']);

    $sql = "INSERT INTO GlobalFood (GlobalFoodID, Name, Description, ServingSize, FatPerServing, CarbPerServing, ProteinPerServing)
            VALUES (NULL, '$name', '$desc', $servingSize, $fatPerServing, $carbsPerServing, $proteinPerServing);";

    $res = $db -> query($sql);

    if($res){
      $response["success"] = true;
    }
  }
  echo json_encode($response);
 ?>
