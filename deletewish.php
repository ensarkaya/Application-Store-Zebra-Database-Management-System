<?php
include 'connect.php';
session_start();
$userID=$_SESSION['id'];
$ap_id = "";
if (isset($_GET['ap_id'])) {
	$ap_id = $_GET['ap_id'];
}

#$deleteSQL = "DELETE FROM add_wish WHERE u_id = '{$_SESSION['id']}' AND app_id = '$ap_id'";
$deleteSQL = "DELETE FROM add_wish WHERE u_id = '$userID' AND app_id = '$ap_id'";
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
    window.location.href='wishlist.php';
    </script>";
} ?>
