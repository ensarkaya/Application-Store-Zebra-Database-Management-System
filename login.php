<?php
include 'connect.php';
session_start();

// check if both fields are filled
if ( $_POST['email'] == "" || $_POST['password'] == "" ) {
	alert("Please fill both fields");
}
// prepare sql stament
else if ($stmt = $con->prepare('SELECT id, n_name, email, phone, password, validation FROM Account WHERE email = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	// check if account exists in our database
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $n_name, $email, $phone, $password, $validation);
        $stmt->fetch();
        // account exists, check the password.
        if ($_POST['password'] === $password){
            // password exists too, log user in and create sessions so that we know in the other pages that the user is logged in
			$sqlUser="SELECT id FROM User WHERE id= '$id'";
			$sqlDeveloper="SELECT id FROM Developer WHERE id= '$id'";
			$sqlPremUser="SELECT id FROM Premium_User WHERE id= '$id'";
			$sqlAdmin="SELECT id FROM Admin WHERE id= '$id'";
			$sqlEditor="SELECT id FROM Editor WHERE id= '$id'";
			$resultUser = mysqli_query($con, $sqlUser);
			$resultDev = mysqli_query($con, $sqlDeveloper);
			$resultPrem = mysqli_query($con, $sqlPremUser);
			$resultAdmin = mysqli_query($con, $sqlAdmin);
			$resultEdi = mysqli_query($con, $sqlEditor);
			session_regenerate_id();
			if (mysqli_num_rows($resultUser) > 0) {$_SESSION['userType'] = "user";}
			else if(mysqli_num_rows($resultDev) > 0){$_SESSION['userType'] = "developer";}
			else if(mysqli_num_rows($resultPrem) > 0){$_SESSION['userType'] = "premium";}
			else if(mysqli_num_rows($resultAdmin) > 0){$_SESSION['userType'] = "admin";}
			else if(mysqli_num_rows($resultEdi) > 0){$_SESSION['userType'] = "editor";}
			else{alert("WTFFFFF");}
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $n_name;
            $_SESSION['id'] = $id;
            $_SESSION['password'] = $password;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
			####user type göre göndermek lazım
			if($_SESSION['userType'] == "user"){header('Location: home.php');}
			else if($_SESSION['userType'] == "developer"){header('Location: developerApplications.php');}
			else if($_SESSION['userType'] == "admin"){header('Location: adminmain.html');}
			else if($_SESSION['userType'] == "editor"){header('Location: editormain.php');}
            
        } 
        else {
            alert("Password is incorrect");
        }
    } 
    else {
        alert("Username does not exist");
    }
    $stmt->close();
}


function alert($msg) {
    echo "<script type='text/javascript'>
        alert('$msg');
        window.location.href='index.html';
        </script>";
}
?>