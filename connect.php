<?php
##you have to connect your database here
   $con = mysqli_connect("", "", "", "");
   if (!$con){
     echo "Connection failed!";
   }
?>
