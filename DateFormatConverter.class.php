<?php

class DateFormatConverter{

  function convert($date){


    if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
      $myDateTime = DateTime::createFromFormat('Y-m-d', $date);
      $retDate = $myDateTime->format('d/m/Y');
      return $retDate;
    }
    else{
      return " / / ";
    }
  }

}


?>
