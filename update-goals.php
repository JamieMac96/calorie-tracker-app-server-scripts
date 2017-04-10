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


    //If we have already weighed in today or the weight has not changed we do not want to create a new entry.
    $checkWeightInDateSQL = " SELECT * FROM BodyweightEntry
                              WHERE User_UserID = $userID
                              ORDER BY WeighInDate DESC;";
    $res = $db -> select($checkWeightInDateSQL);
    if($res[0]['WeighInDate'] == date('Y-m-d') || $res[0]['Weight'] == $bodyweight){
      $doNotAddNewEntryFlag = true;
    }


    $checkSQL = "SELECT * FROM UserDetails WHERE User_UserID = $userID;";
    $checkResult = $db -> select($checkSQL);

    if($checkResult){
      $updateSQL = "UPDATE `UserDetails` SET `WeeklyGoal`='$weeklyGoal',`ActivityLevel`='$activityLevel',
              `Bodyweight`=$bodyweight,`GoalWeight`=$goalBodyweight,`CalorieGoal`=$calorieGoal,`ProteinGoalPercent`=$proteinPercentage,
              `CarbGoalPercent`=$carbPercentage,`FatGoalPercent`=$fatPercentage
              WHERE User_UserID = $userID;";

      $updateRes = $db -> query($updateSQL);

      if(!$doNotAddNewEntryFlag){
        $newEntry = addNewProgressEntry($bodyweight, $userID);
      }
      
      if($updateRes && ($newEntry || $doNotAddNewEntryFlag)){
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
      $newEntry = addNewProgressEntry($bodyweight, $userID);
      if($insertRes && $newEntry){
        outputTrue();
      }
      else{
        outputFalse();
      }
    }
  }
  else{
    outputFalse();
  }

  function addNewProgressEntry($bodyweight, $userID){
    global $db;

    $currentDate = date('Y-m-d');

    $sql = "INSERT INTO `BodyweightEntry`(`EntryID`, `User_UserID`, `Weight`, `WeighInDate`) VALUES (NULL,$userID,$bodyweight,'$currentDate');";

    $res = $db -> query($sql);
    if($res){
      return true;
    }
    else{
      return false;
    }
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
