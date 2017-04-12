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
      $result[$i] = array($res[$i]['Name'], $res[$i]['Description'], $res[$i]['ServingSize'], $res[$i]['FatPerServing'], $res[$i]['ProteinPerServing'], $res[$i]['CarbPerServing'] );
    }
    $response['result'] = $result;
  }
}
echo json_encode($response);

 ?>
