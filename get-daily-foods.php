<?php

  //Add implementation after we have implemented ability to add foods in AddFoodActivity

  $response = array();
  $response['success'] = false;

  if(isset($_POST['userID'])){
    include('/var/www/html/DatabaseHelper.class.php');
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
        $result[$i] = array($res[$i]['Name'], $res[$i]['Description'] ,
        $res[$i]['ServingSize'], $res[$i]['NumServings'], $res[$i]['FatPerServing'], $res[$i]['ProteinPerServing'], $res[$i]['CarbPerServing'], $res[$i]['FoodID'], $res[$i]['GlobalFoodID']);
      }
      $response['result'] = $result;
    }
    //if there are no daily foods for the user they should still be logged in.
    //however if $res has a size of 1 (and it is false) then we response will be false.
    else if(sizeof($res) == 0){
      $response['success'] = true;
    }
  }
  echo json_encode($response);
 ?>
