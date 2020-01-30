<?php
include 'connect.php';
session_start();
$userID=$_SESSION['id'];

$errors = array();
if( isset($_POST['create_editor']))
{
  if($_POST['adding_editor_name'] == "" || $_POST['adding_editor_email'] == "" || $_POST['adding_editor_phone'] == "" ||$_POST['adding_editor_password'] == "" ){
    alert("Please fill all the fields");
  }
  else{

    $adding_editor_email1 = mysqli_real_escape_string($con,$_POST['adding_editor_email']);
    $adding_editor_name1 = mysqli_real_escape_string($con,$_POST['adding_editor_name']);
    $adding_editor_password1 = mysqli_real_escape_string($con,$_POST['adding_editor_password']);
    $adding_editor_phone1 = mysqli_real_escape_string($con,$_POST['adding_editor_phone']);
    $query__1 = "INSERT INTO Account(email, n_name, phone, password, validation) VALUES ('$adding_editor_email1', '$adding_editor_name1', '$adding_editor_phone1', '$adding_editor_password1', 0)";
    mysqli_query($con, $query__1);
	$editor_id = mysqli_insert_id($con);
## buraya aç TODO
#    $editor_id = "SELECT id FROM Account WHERE email = '$adding_editor_email1'";
#	mysqli_query($con, $editor_id);
#	$row2 = mysqli_fetch_assoc($result2);
#	$editor_id=row2["id"];
    $query_add_editor = "INSERT INTO Editor(id, adm_id) VALUES('$editor_id', '$userID')";
	mysqli_query($con, $query_add_editor);
    alert("success");
  }
}
///DELETE
elseif (isset($_POST['del_acnt'])) {
  $check_if_del2 = $_POST['del_ed2'];
  $delete_check_query_pop2 = "SELECT id FROM Account WHERE email= '$check_if_del2'";
  $result_of_del2 = mysqli_query($con, $delete_check_query_pop2);

  if($_POST['del_ed2'] == "")
  {
    delete_pop("Enter something!");
  }
  else if (mysqli_num_rows($result_of_del2) == 0 ) { // if user exists
    delete_pop("Email does not exist");
  }

  else if ( $_POST['del_ed2'] == "" ) {
  	delete_pop("Please enter an email");
  }

  else if ($stmt = $con->prepare('DELETE FROM Account WHERE email = ?')) {
    $stmt->bind_param('s', $_POST['del_ed2']);
    $stmt->execute();
    $stmt->close();
    delete_pop("The account is deleted");
  }

  else{
    delete_pop("Email does not exist");
  }
}

function alert($msg){
  echo "<script type='text/javascript'>
    alert('$msg');
    window.location.href='adminmain.html';
    </script>";
}

function delete_pop($msg){
  echo "<script type='text/javascript'>
    alert('$msg');
    window.location.href='admin add.html';
    </script>";
}
 ?>
