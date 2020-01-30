<?php
include 'connect.php';
session_start();
$approved="approved";
$pending="pending";
$userID =$_SESSION['id'];
$input="a";
#$query_sel = "SELECT id FROM Application WHERE n_name like '%'$input'%' AND id IN( SELECT app_id FROM Request WHERE state = '$approved')";
$query_sel =  "SELECT * FROM Application WHERE n_name like '%$input%' AND id IN( SELECT app_id FROM Request WHERE state = '$approved')";
$result =  mysqli_query($con,$query_sel);
$data = "";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
	$data .= "<table><tr><th width=\"20%\">Application Name</th>
	<th width=\"20%\">Description</th>
	<th width=\"20%\">dl_count</th>
	<th width=\"20%\">Version</th>
	<th width=\"20%\">Rate</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
		$ap_id= $row["id"];
		$query="SELECT AVG(rate) FROM Review WHERE app_id = '$ap_id'";
		$result2 =  mysqli_query($con,$query);
		$row2 = mysqli_fetch_assoc($result2);
		$data .= "<tr><td style=\"text-align:center\" width=\"20%\">" . $row["n_name"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . $row["description"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row["dl_count"]). 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row["version"]).
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row2["AVG(rate)"]).
		"</td><td style=\"text-align:center\" width =\"20%\"><a href=\"application.php?ap_id=" . $row["id"] .  "&version=" . $row["version"] . "\">Go to Application</a></td></tr>";
    }
    $data .= "</table>";
} 
else {
    $data .= "You don't have any approved apps";
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Zebra</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
  </head>
  <body>

    <p></p>

    <style type="text/css">
      body { background-color:white; color:black; }
      p { font-family: Tahoma, Verdana; font-size: 19px; }
    </style>

    <h1 class="ui header" style="margin-left: 166px">
      <i class="search icon"></i>
      <div class="content">
        Search Results:
      </div>
    </h1>

    <div class="ui inverted vertical labeled icon ui overlay left thin visible sidebar menu">
		<a class="item" onclick="window.location='home.php';">
		<i aria-hidden="true" class="home icon"></i>
		Home
		</a>
		<a class="item" onclick="window.location='wallet.php';">
		<i aria-hidden="true" class="credit card icon"></i>
		Wallet
		</a>
		<a class="item" onclick="window.location='wishlist.php';">
		<i aria-hidden="true" class="list icon"></i>
		Wishlist
		</a>
		<a class="item" onclick="window.location='devices.php';">
		<i aria-hidden="true" class="computer icon"></i>
		Device
		</a>
		<a class="item" onclick="window.location='purchased.php';">
		<i aria-hidden="true" class="archive icon" ></i>
		Purchased
		</a>
		<a class="item" onclick="window.location='update.php';">
		<i aria-hidden="true" class="upload icon" ></i>
		Update
		</a>
<a class="item" onclick="window.location='index.html';">
		<i aria-hidden="true" class="sign-out icon" ></i>
		Log-out
		</a>
    </div>

    <!-- each of these will be an application, each application should be linked to the application page-->
    <div class="ui five column stackable grid" style="margin-left: 156px; margin-right: 10px;">
		<div>
			<p><b style="font-size:24px;"></b></p>
			<?=$data?>
		</div>	
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

  </body>
</html>
