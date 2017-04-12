<?php

  //Add implementation after we have implemented ability to add foods in AddFoodActivity

  $response = array();
  $response['success'] = false;

  if(isset($_POST['userID'])){
    include('/var/www/html/calorie-tracker-app-server-scripts/DatabaseHelper.class.php');
    $db = new DatabaseHelper();

    $userID = $db -> quote($_POST['userID']);
    $date = date('Y-m-d');

    $dailyFoodsSQL = "SELECT * FROM GlobalFood
                      JOIN DailyFood
                      ON GlobalFood.GlobalFoodID = DailyFood.GlobalFood_GlobalFoodID
                      WHERE User_UserID = $userID
                      AND DailyFood.Date = '$date';";


    $res = $db -> select($dailyFoodsSQL);
    if($res){
      $result = array();
      $response['success'] = true;
      
      for($i = 0; $i < sizeof($res); $i++){
        $result[$i] = array($res[$i]['Date'], $res[$i]['NumServings'], $res[$i]['Name'], $res[$i]['Description'] ,
        $res[$i]['ServingSize'], $res[$i]['FatPerServing'], $res[$i]['ProteinPerServing'], $res[$i]['CarbPerServing'] );
      }
      $response['result'] = $result;
    }
  }
  echo json_encode($response);
 ?>
