<?php
include 'connect.php';
session_start();
$userID=$_SESSION['id'];
$ap_id="";
$version="";
$ap_id = "";
if (isset($_GET['ap_id']) && isset($_GET['version'])) {
	$ap_id = $_GET['ap_id'];
	$version = $_GET['version'];
}

#$deleteSQL = "UPDATE owns SET owns.user_version = '$version' WHERE owns.app_id = '$ap_id' AND owns.u_id = '$userID'";
$deleteSQL = "UPDATE owns SET owns.user_version = '$version' WHERE owns.app_id = '$ap_id' AND owns.u_id = 45";
if(mysqli_query($con, $deleteSQL))
{
	alert("success");
	
}
else {
  alert("fail");
}

function alert($msg){
  echo "<script type='text/javascript'>
    alert('$msg');
    window.location.href='update.php';
    </script>";
} ?>