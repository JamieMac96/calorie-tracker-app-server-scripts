<?php

$response = array();
$response['success'] = false;


if(isset($_POST['foodID'])){
  echo "hello";
  include_once('/var/www/html/DatabaseHelper.class.php');
  $db = new DatabaseHelper();
  $globalFoodID = $db -> quote($_POST['foodID']);
  $userID = $db -> quote($_POST['userID']);

  $removeDailyFoodSQl = "DELETE FROM `DailyFood` WHERE FoodID = $globalFoodID AND User_UserID = $userID;";

  $removeDailyFoodRes = $db -> query($removeDailyFoodSQl);

  if($removeDailyFoodRes){
    $response['success'] = true;
  }
}

echo json_encode($response, JSON_FORCE_OBJECT);

 ?>
