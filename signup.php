<?php
include 'connect.php';
session_start();

$errors = array();
$flag=0;

#if (isset($_POST['back'])) {
#    header('location: index.html');}

    // receive all input values from the form
	
	$username = mysqli_real_escape_string($con, $_POST['name']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$phone = mysqli_real_escape_string($con, $_POST['phonenum']);
	$bdate = $_POST['birth_date'];
	// form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
	if (empty($phone)) { array_push($errors, "Phone Number is required"); }
	if (empty($bdate)) { array_push($errors, "Birth Day is required"); }

//first check the database to make sure 
$email_check_query = "SELECT id FROM Account WHERE email='$email'";
$result = mysqli_query($con, $email_check_query);
if ( mysqli_num_rows($result) > 0 ) { // if user exists
    array_push($errors, "Username already exists");
}

// Finally, register user if there are no errors in the form
if (count($errors) == 0) {
	$val = "0";
	$query = "INSERT INTO Account(email, n_name, phone, password, validation) VALUES ('$email', '$username', '$phone', '$password', '$val')";
	mysqli_query($con, $query);
	$newId = mysqli_insert_id($con);
    if(isset($_POST['userSignUp'])){
		$query3 = "INSERT INTO Wallet(id) VALUES('$newId')";
		mysqli_query($con, $query3);
		
        $query1 = "INSERT INTO User (id, birthday, w_id) VALUES('$newId', '$bdate', '$newId')";
		mysqli_query($con, $query1);
	}
	else if(isset($_POST['developerSignUp'])){
		$query2 = "INSERT INTO Developer (id,adm_id) VALUES('$newId',61)";
		mysqli_query($con, $query2);
	}
	alert("Your account has been created");
}
else //display errors if any
{
    $alertMsg = array_pop($errors);
    foreach( $errors as $counter ){
        $alertMsg .= ", " . array_pop($errors);
    }
    alert($alertMsg);
}

function alert($msg) {
    echo "<script type='text/javascript'>
        alert('$msg');
        window.location.href='index.html';
        </script>";
}
?>
