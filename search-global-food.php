<?php
  $response = array();
  if(isset($_POST['searchQuery'])){
    include('/var/www/html/calorie-tracker-app-server-scripts/DatabaseHelper.class.php');
    $db = new DatabaseHelper();

    $searchQuery = $db -> quote(htmlentities($_POST['searchQuery']));

    $searchSQL = "SELECT * FROM GlobalFood
                  WHERE Name LIKE '%$searchQuery%'
                  LIMIT 0, 20;";

    $res = $db -> select($searchSQL);

    if($res){
      $response['success'] = true;
      $result = array();
      for($i = 0; $i < sizeof($res); $i++){
        $result[$i] = array($res[$i]['GlobalFoodID'], $res[$i]['Name'], $res[$i]['Description'],$res[$i]['ServingSize'],
                            $res[$i]['FatPerServing'], $res[$i]['CarbPerServing'], $res[$i]['ProteinPerServing']);
      }
      $response['result'] = $result;
      echo json_encode($response);
    }
    else{
      $response['success'] = false;
      echo json_encode($response);
    }
  }
  else{
    $response['success'] = false;
    echo json_encode($response);
  }


 ?>
