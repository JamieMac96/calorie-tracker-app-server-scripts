<?php
  $response = array();
  $response['success'] = false;


  if(isset($_POST['foodID'])){
    include_once('/var/www/html/DatabaseHelper.class.php');
    $db = new DatabaseHelper();
    $globalFoodID = $db -> quote($_POST['foodID']);
    $numServings = $db -> quote($_POST['numServings']);
    $userID = $db -> quote($_POST['userID']);
    $date = date('Y-m-d');


    $addDailyFoodSQl = "INSERT INTO `DailyFood`(`FoodID`, `User_UserID`, `GlobalFood_GlobalFoodID`, `NumServings`, `Date`)
                        VALUES (NULL,$userID,$globalFoodID,$numServings, '$date');";

    $addDailyFoodresult = $db -> query($addDailyFoodSQl);

    if($addDailyFoodresult){
      $checkIfUserFoodExistsSQL = " SELECT * FROM UserFood
                                    WHERE User_UserID = $userID AND GlobalFood_GlobalFoodID = $globalFoodID;";

      if(! $db -> select($checkIfUserFoodExistsSQL)){
        $addUserFoodSQL = "INSERT INTO `UserFood`(`UserFoodID`, `GlobalFood_GlobalFoodID`, `User_UserID`) VALUES (NULL,$globalFoodID,$userID);";

        if($db -> query($addUserFoodSQL)){
          $response['success'] = true;
        }
      }
      else{
        $response['success'] = true;
      }
    }

  }


  echo json_encode($response, JSON_FORCE_OBJECT);
 ?>
