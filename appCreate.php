<?php
include 'connect.php';
session_start();

$errors = array();

#if (isset($_POST['back'])) {
#    header('location: index.html');}

    // receive all input values from the form
	
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$description = mysqli_real_escape_string($con, $_POST['description']);
	$size =$_POST['size'];
	$version = $_POST['version'];
	$price = $_POST['price'];
	#####################$dev_id =$_SESSION['id'];
	$dev_id =$_SESSION['id'];
	#################burası editlencekkkk
	$category=$_POST['categorySel'];
	// form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($name)) { array_push($errors, "name is required"); }
    if (empty($description)) { array_push($errors, "description is required"); }
    if (empty($size)) { array_push($errors, "min_ram is required"); }
	if (empty($version)) { array_push($errors, "version Number is required"); }
	if (empty($price)) { array_push($errors, "price is required"); }
	if (empty($dev_id)) { array_push($errors, "dev_id is required"); }	
	if (empty($category)) { array_push($errors, "category is required"); }	
//first check the database to make sure 
$check_query = "SELECT id FROM Application WHERE n_name='$name'";
$result = mysqli_query($con, $check_query);
if ( mysqli_num_rows($result) > 0 ) { // if app exists
    //array_push($errors, "Application name already exists");
}
$publishstr = "publish";
$pendingstr = "pending";
$updatestr = "update";
// Finally, register user if there are no errors in the form
if (count($errors) == 0) {

    if(isset($_POST['upload'])){
		$val = "0";

		$query = "INSERT INTO Application(n_name, description, min_ram, price, dl_count, version, dev_id, date) VALUES('$name', '$description', '$size', '$price', 0,'$version' ,'$dev_id', NOW())";
		mysqli_query($con, $query);
		$appId = mysqli_insert_id($con);	
		$query3 = "INSERT INTO belong_to(c_name, app_id) VALUES('$category', '$appId')";
		mysqli_query($con, $query3);
		
        $query1 = "INSERT INTO Request(type, app_id, dev_id, state) VALUES('$publishstr', '$appId', '$dev_id', '$pendingstr')";
		mysqli_query($con, $query1);
		alert("Your application has been uploaded");
	}
	if(isset($_POST['update'])){
		$query2 = "UPDATE Application SET description = '$description', version = '$version', min_ram='$size', price='$price' WHERE n_name = '$name'";
		mysqli_query($con, $query2);
		
		$query22 = "select id from Application WHERE n_name = '$name'";
		$result=mysqli_query($con, $query22);
		$row = mysqli_fetch_assoc($result);	
		$a_id=$row["id"];
		$query5 = "INSERT INTO Request(type, app_id, dev_id, state) VALUES ('$updatestr', '$a_id' , '$dev_id', '$pendingstr')";
		mysqli_query($con, $query5);
			
		alert($a_id);
	}
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
        window.location.href='developer create.html';
        </script>";
}
?>


