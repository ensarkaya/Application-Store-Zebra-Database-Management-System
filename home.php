<?php
include 'connect.php';
session_start();
$userID=$_SESSION['id'];
##1 new arrivals
$query_sel = "SELECT * FROM approved_apps WHERE DATEDIFF(date,NOW())<7 limit 10";
$result =  mysqli_query($con,$query_sel);
$data = "";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
	$data .= "<table class=\"ui inverted table\"><tr><th width=\"20%\">Application Name</th>
	<th width=\"20%\">Description</th>
	<th width=\"20%\">price</th>
	<th width=\"20%\">dl_count</th>
	<th width=\"20%\">version</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
		$data .= "<tr><td style=\"text-align:center\" width=\"20%\">" . $row["n_name"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . $row["description"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row["price"]). 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row["dl_count"]). 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row["version"]).
		"</td><td style=\"text-align:center\" width =\"20%\"><a href=\"application.php?ap_id=".$row["id"]."\">Go to Application</a></td></tr>";
    }													
    $data .= "</table>";
} 
else {
    $data .= "You don't have any wished app";
}
##2 top apps
$query_sel2 = "SELECT * FROM approved_apps limit 10";
$result2 =  mysqli_query($con,$query_sel2);
$data2 = "";
if (mysqli_num_rows($result2) > 0) {
    // output data of each row
	$data2 .= "<table class=\"ui inverted table\"><tr><th width=\"20%\">Application Name</th>
	<th width=\"20%\">Description</th>
	<th width=\"20%\">price</th>
	<th width=\"20%\">dl_count</th>
	<th width=\"20%\">version</th></tr>";
    while($row2 = mysqli_fetch_assoc($result2)) {
		$data2 .= "<tr><td style=\"text-align:center\" width=\"20%\">" . $row2["n_name"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . $row2["description"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row2["price"]). 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row2["dl_count"]). 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row2["version"]).
		"</td><td style=\"text-align:center\" width =\"20%\"><a href=\"application.php?ap_id=".$row2["id"]."\">Go to Application</a></td></tr>";
    }
    $data2 .= "</table>";
} 
else {
    $data2 .= "You don't have any wished app";
}
##filter price
$data3 = "";
if (isset($_POST['ara'])) {
    $max= $_POST['maxP'];
$min=$_POST['minP'];
$query_sel3 = "SELECT * FROM approved_apps WHERE price<'$max' and price>'$min' limit 10";
$result3 =  mysqli_query($con,$query_sel3);
if (mysqli_num_rows($result3) > 0) {
    // output data of each row
	$data3 .= "<table class=\"ui inverted table\"><tr><th width=\"20%\">Application Name</th>
	<th width=\"20%\">Description</th>
	<th width=\"20%\">price</th>
	<th width=\"20%\">dl_count</th>
	<th width=\"20%\">version</th></tr>";
    while($row3 = mysqli_fetch_assoc($result3)) {
		$data3 .= "<tr><td style=\"text-align:center\" width=\"20%\">" . $row3["n_name"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . $row3["description"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row3["price"]). 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row3["dl_count"]). 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row3["version"]).
		"</td><td style=\"text-align:center\" width =\"20%\"><a href=\"application.php?ap_id=".$row3["id"]."\">Go to Application</a></td></tr>";
    }
    $data3 .= "</table>";
} 
else {
    $data3 .= "Please enter min and max values";
}
}	
##berfin price
$data4 = "";
$query_sel4 = "SELECT * FROM Application A, belong_to B, best_avg_rate Best, Review R WHERE A.id = B.app_id AND B.c_name = Best.c_name AND R.app_id = A.id AND R.rate = Best.max_rate";
$result4 =  mysqli_query($con,$query_sel4);
if (mysqli_num_rows($result4) > 0) {
    // output data of each row
	$data4 .= "<table class=\"ui inverted table\"><tr><th width=\"20%\">Application Name</th>
	<th width=\"20%\">Description</th>
	<th width=\"20%\">price</th>
	<th width=\"20%\">dl_count</th>
	<th width=\"20%\">version</th></tr>";
    while($row4 = mysqli_fetch_assoc($result4)) {
		$data4 .= "<tr><td style=\"text-align:center\" width=\"20%\">" . $row4["n_name"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . $row4["description"]. 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row4["price"]). 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row4["dl_count"]). 
		"</td><td style=\"text-align:center\" width=\"20%\">" . number_format($row4["version"]).
		"</td><td style=\"text-align:center\" width =\"20%\"><a href=\"application.php?ap_id=".$row4["id"]."\">Go to Application</a></td></tr>";
    }
    $data4 .= "</table>";
} 
else {
    $data4 .= "";
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


    <div class="ui segment pushable">

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
	  
	       <form class="" action="category.php" method="post">

      <div class="ui inverted vertical labeled icon ui overlay right thin visible sidebar menu";>
        <div class="ui segment">
          <i aria-hidden="true" class="gamepad icon"></i>
          <input type="submit" value="Games" name="Game">
        </div>
        <div class="ui segment">
          <i aria-hidden="true" class="hashtag icon"></i>
          <input type="submit" value="Social Networking" name="Social">
        </div>
        <div class="ui segment">
          <i aria-hidden="true" class="music icon"></i>
          <input type="submit" value="Music" name="Music">
        </div>
        <div class="ui segment">
          <i aria-hidden="true" class="book icon"></i>
          <input type="submit" value="Education" name="Education">
        </div>
        <div class="ui segment">
          <i aria-hidden="true" class="edit icon"></i>
          <input type="submit" value="Tools" name="Tools">
        </div>
        <div class="ui segment">
          <i aria-hidden="true" class="whatsapp icon"></i>
          <input type="submit" value="Messaging" name="Messaging">
        </div>
        <div class="ui segment">
          <i aria-hidden="true" class="heart icon"></i>
          <input type="submit" value="Dating" name="Dating">
        </div>
      </div>
    </form>
	  



        <form class="ui fluid icon input" style="margin-left: 156px; margin-right: 156px;" action="search.php" method="post">
          <input type="text" placeholder="Search..." /> 
          <i aria-hidden="true" class="search icon"></i>
        </form>


      <h2 class="ui header" style="margin-left:170px; margin-right: 156px; margin-top:10px;">
        <i class="eye icon"></i>
        <div class="content">
          New Arrivals
        </div>
      </h2>

       <div  style="margin-left: 156px; margin-right: 156px;">
		<div>
			<p><b style="font-size:24px;"></b></p>
			<?=$data?>
		</div>	
		</div>


      <h2 class="ui header" style="margin-left:170px; margin-right: 156px; margin-top:10px;">
        <i class="star icon"></i>
        <div class="content">
          Top Applications
        </div>
      </h2>

    <div  style="margin-left: 156px; margin-right: 156px; ">
		<div>
			<p><b style="font-size:24px;"></b></p>
			<?=$data2?>
		</div>	
    </div>

	<h2 class="ui header" style="margin-left:170px; margin-right: 156px; margin-top:10px;">
        <i class="star icon"></i>
        <div class="content">
          Price
        </div>
      </h2>
	<form action="home.php" method="post">
	  <div class="ui right labeled input" style="margin-left:170px; margin-top:10px; margin-right: 156px;">
        <label for="version" class="ui label">Min Price</label>
        <input type="number" placeholder="Min Price" min="0" max="9999999999" id="minP" name="minP">
		<div class="ui basic label"></div>
      </div>
	  	  <div class="ui right labeled input" style="margin-left:170px; margin-top:10px; margin-right: 156px;">
        <label for="version" class="ui label">Max Price</label>
        <input type="number" placeholder="Max Price" min="0" max="9999999999" id="maxP" name="maxP">
		<div class="ui basic label"></div>
      </div>
	  
			<input class="ui large positive button" type="submit" name="ara" value="Go for it!!">

	</form>
    <div  style="margin-left: 156px; margin-right: 156px;">
		<div>
			<p><b style="font-size:24px;"></b></p>
			<?=$data3?>
		</div>	
    </div>



<h2 class="ui header" style="margin-left:170px; margin-right: 156px; margin-top:10px;">
        <i class="star icon"></i>
        <div class="content">
          Best of Each Category
        </div>
      </h2>
	  
	  <div  style="margin-left: 156px; margin-right: 156px;">
		<div>
			<p><b style="font-size:24px;"></b></p>
			<?=$data4?>
		</div>	
    </div>

      

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

  </body>
</html>
