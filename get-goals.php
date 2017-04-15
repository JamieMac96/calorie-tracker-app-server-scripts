<?php

  $response = array();

  if(isset($_POST['userID'])){
    include('/var/www/html/DatabaseHelper.class.php');
    $db = new DatabaseHelper();

    $userID = $db -> quote($_POST['userID']);
    $sql = "SELECT * FROM UserDetails WHERE User_UserID = '$userID';";
    $result = $db -> select($sql);

    if($result){
      $userIDFromTable = $result[0]['User_UserID'];
      $weeklyGoal = $result[0]['WeeklyGoal'];
      $activityLevel = $result[0]['ActivityLevel'];
      $initialBodyweight = $result[0]['InitialBodyweight'];
      $bodyweight = $result[0]['Bodyweight'];
      $goalBodyWeight = $result[0]['GoalWeight'];
      $calorieGoal = $result[0]['CalorieGoal'];
      $fatPercentage = $result[0]['FatGoalPercent'];
      $proteinPercentage = $result[0]['ProteinGoalPercent'];
      $carbPercentage = $result[0]['CarbGoalPercent'];

      $response['success'] = true;
      $response['weeklyGoal'] = $weeklyGoal;
      $response['activityLevel'] = $activityLevel;
      $response['initialBodyweight'] = $initialBodyweight;
      $response['bodyweight'] = $bodyweight;
      $response['goalBodyWeight'] = $goalBodyWeight;
      $response['calorieGoal'] = $calorieGoal;
      $response['fatPercentage'] = $fatPercentage;
      $response['proteinPercentage'] = $proteinPercentage;
      $response['carbPercentage'] = $carbPercentage;
      $response['userID'] = $userIDFromTable;

      echo json_encode($response, JSON_FORCE_OBJECT);
    }
    //on if $result has value false do we want to return false. If it is simply an empty result we return true.
    else if(sizeof($result) == 0){
      $response['success'] = true;
      echo json_encode($response);
    }
    else{
      $response['success'] = false;
      echo json_encode($response, JSON_FORCE_OBJECT);
    }
  }
  else{
    $response['success'] = false;
    echo json_encode($response, JSON_FORCE_OBJECT);
  }


 ?>
