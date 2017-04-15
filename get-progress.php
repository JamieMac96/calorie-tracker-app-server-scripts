<?php
  include_once('/var/www/html/DatabaseHelper.class.php');
  include_once('/var/www/html/DateFormatConverter.class.php');

  $response = array();
  $response['success'] = false;

  if(isset($_POST['userID'])){
    $db = new DatabaseHelper();
    $converter = new DateFormatConverter();

    $userID = $db -> quote($_POST['userID']);

    $sql = "SELECT * FROM BodyweightEntry
            WHERE User_UserID = $userID
            ORDER BY WeighInDate DESC
            LIMIT 0, 50;";

    $entries = $db -> select($sql);

    if($entries){
      $response['success'] = true;
      $result = array();
      for($i = 0; $i < sizeof($entries); $i++){
        $result[$i] = array($converter->convert($entries[$i]['WeighInDate']), $entries[$i]['Weight']);
      }
      $response['result'] = $result;
      echo json_encode($response);
    }
    //on if $result has value false do we want to return false. If it is simply an empty result we return true.
    else if(sizeof($entries) == 0){
      $response['success'] = true;
      echo json_encode($response);
    }
    else{
      echo json_encode($response, JSON_FORCE_OBJECT);
    }
  }
  echo json_encode($response, JSON_FORCE_OBJECT);

 ?>
