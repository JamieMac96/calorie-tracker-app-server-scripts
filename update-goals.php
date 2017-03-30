<?php
include_once('/var/www/html/calorie-tracker-app-server-scripts/DatabaseHelper.class.php');
$response = array();
  if(isset($_POST['userID'])){
    $db = new DatabaseHelper();
    $userID = $db -> quote($_POST['userID']);
    $initialBodyweight = $db -> quote($_POST['initialBodyweight']);
    $bodyweight = $db -> quote($_POST['bodyweight']);
    $goalBodyweight = $db -> quote($_POST['goalBodyweight']);
    $calorieGoal = $db -> quote($_POST['calorieGoal']);
    $weeklyGoal = $db -> quote($_POST['weeklyGoal']);
    $activityLevel = $db -> quote($_POST['activityLevel']);
    $fatPercentage = $db -> quote($_POST['fatPercentage']);
    $carbPercentage = $db -> quote($_POST['carbPercentage']);
    $proteinPercentage = $db -> quote($_POST['proteinPercentage']);

    $checkSQL = "SELECT * FROM UserDetails WHERE User_UserID = $userID;";
    $checkResult = $db -> select($checkSQL);

    if($checkResult){
      $updateSQL = "UPDATE `UserDetails` SET `WeeklyGoal`='$weeklyGoal',`ActivityLevel`='$activityLevel',
              `Bodyweight`=$bodyweight,`GoalWeight`=$goalBodyweight,`CalorieGoal`=$calorieGoal,`ProteinGoalPercent`=$proteinPercentage,
              `CarbGoalPercent`=$carbPercentage,`FatGoalPercent`=$fatPercentage
              WHERE User_UserID = $userID;";

      $updateRes = $db -> query($updateSQL);
      if($updateRes){
        outputTrue();
      }
      else{
        outputFalse();
      }
    }
    else{
      $insertSQL = "INSERT INTO `UserDetails`(`User_UserID`, `WeeklyGoal`, `ActivityLevel`, `InitialBodyweight`, `Bodyweight`,
                                `GoalWeight`, `CalorieGoal`, `ProteinGoalPercent`, `CarbGoalPercent`, `FatGoalPercent`)
                    VALUES ($userID,'$weeklyGoal','$activityLevel',$initialBodyweight,$bodyweight,$goalBodyweight,$calorieGoal,$proteinPercentage,$carbPercentage,$fatPercentage);";
      $insertRes = $db -> query($insertSQL);
      if($insertRes){
        outputTrue();
      }
      else{
        outputFalse();
      }
    }
    addNewProgressEntry($bodyweight, $userID);
  }
  else{
    outputFalse();
  }

  function addNewProgressEntry($bodyweight, $userID){
    global $db;

    $currentDate = date('Y-m-d');

    $sql = "INSERT INTO `BodyweightEntry`(`EntryID`, `User_UserID`, `Weight`, `WeighInDate`) VALUES (NULL,$userID,$bodyweight,'$currentDate');";

    $db -> query($sql);
  }

  function outputFalse(){
    $response = array();
    $response['success'] = false;
    echo json_encode($response, JSON_FORCE_OBJECT);
  }

  function outputTrue(){
    $response = array();
    $response['success'] = true;
    echo json_encode($response, JSON_FORCE_OBJECT);
  }

 ?>
