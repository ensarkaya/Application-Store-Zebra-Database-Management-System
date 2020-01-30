<?php
include 'connect.php';


if( isset($_POST['editor_button']))
{
  header('Location: admin add.html');
}

else if($_POST['del_button'] ){
  $check_if_del = $_POST['email_to_delete'];
  $delete_check_query_pop = "SELECT id FROM Account WHERE email= '$check_if_del'";
  $result_of_del = mysqli_query($con, $delete_check_query_pop);

  if($_POST['email_to_delete'] == "")
  {
    alert("Enter something!");
  }
  else if (mysqli_num_rows($result_of_del) == 0 ) { // if user exists
    alert("Email does not exist");
  }

  else if ( $_POST['email_to_delete'] == "admin@gmail.com" ) {
  	alert("Admin cannot be deleted!");
  }

  else if ( $_POST['email_to_delete'] == "" ) {
  	alert("Please enter an email");
  }

  else if ($stmt = $con->prepare('DELETE FROM Account WHERE email = ?')) {
    $stmt->bind_param('s', $_POST['email_to_delete']);
    $stmt->execute();
    $stmt->close();
    alert("The account is deleted");
  }

  else{
    alert("Email does not exist");
  }
}

function alert($msg){
  echo "<script type='text/javascript'>
    alert('$msg');
    window.location.href='adminmain.html';
    </script>";
}



 ?>
