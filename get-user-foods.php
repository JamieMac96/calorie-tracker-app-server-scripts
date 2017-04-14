<?php

$response = array();
$response['success'] = false;

if(isset($_POST['userID'])){
  include('/var/www/html/calorie-tracker-app-server-scripts/DatabaseHelper.class.php');
  $db = new DatabaseHelper();

  $userID = $db -> quote($_POST['userID']);

  $userFoodsSQL = "SELECT * FROM GlobalFood
                    JOIN UserFood
                    ON GlobalFood.GlobalFoodID = UserFood.GlobalFood_GlobalFoodID
                    WHERE User_UserID = $userID;";


  $res = $db -> select($userFoodsSQL);
  if($res){
    $result = array();
    $response['success'] = true;

    for($i = 0; $i < sizeof($res); $i++){
      $result[$i] = array($res[$i]['Name'], $res[$i]['Description'], $res[$i]['ServingSize'], $res[$i]['FatPerServing'], $res[$i]['ProteinPerServing'], $res[$i]['CarbPerServing'], $res[$i]['GlobalFoodID']);
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
