<?php
include 'connect.php';
session_start();
$ap_id = "";
if (isset($_GET['ap_id'])) {
	$ap_id = $_GET['ap_id'];
}
$deleteSQL = "DELETE FROM Application WHERE id = '$ap_id'";
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
    window.location.href='developerApplications.php';
    </script>";
} ?>
