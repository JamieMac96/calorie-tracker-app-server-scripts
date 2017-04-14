<?php

$response = array();
$response['success'] = false;


if(isset($_POST['foodID'])){
  include_once('/var/www/html/calorie-tracker-app-server-scripts/DatabaseHelper.class.php');
  $db = new DatabaseHelper();
  $globalFoodID = $db -> quote($_POST['foodID']);
  $numServings = $db -> quote($_POST['numServings']);
  $userID = $db -> quote($_POST['userID']);
  $date = date('Y-m-d');


  $updateDailyFoodSQl = "UPDATE `DailyFood` SET `NumServings`=$numServings
                      WHERE FoodID = $globalFoodID
                      AND `Date`='$date';";

  $updateDailyFoodRes = $db -> query($updateDailyFoodSQl);

  if($updateDailyFoodRes){
    $response['success'] = true;
  }
}

echo json_encode($response, JSON_FORCE_OBJECT);


 ?>
