<?php
  include_once('/var/www/html/calorie-tracker-app-server-scripts/DatabaseHelper.class.php');
  include_once('/var/www/html/calorie-tracker-app-server-scripts/DateFormatConverter.class.php');

  $response = array();

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
    else{
      echo json_encode($response, JSON_FORCE_OBJECT);
    }
  }
  else{
    echo json_encode($response, JSON_FORCE_OBJECT);
  }

 ?>
