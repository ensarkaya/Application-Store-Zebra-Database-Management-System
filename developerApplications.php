<?php
include 'connect.php';
session_start();
$approved="approved";
$pending="pending";
$userID=$_SESSION['id'];
#$query_sel = "SELECT id, n_name, description,  price, dl_count, version FROM Application WHERE id in (SELECT app_id FROM Request WHERE dev_id = '$userID'  and state="approved")";
$query_sel = "SELECT id, n_name, description,  price, dl_count, version FROM Application WHERE id in (SELECT app_id FROM Request WHERE dev_id = 11  and state='$approved')";
$result =  mysqli_query($con,$query_sel);
$data = "";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
	$data .= "<table><tr><th width=\"20%\">Application Name</th>
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
		"</td><td style=\"text-align:center\" width =\"20%\"><a href=\"deleteDevApp.php?ap_id=" . $row["id"]."\">Delete Application</a></td></tr>";
    }
    $data .= "</table>";
} 
else {
    $data .= "You don't have any approved apps";
}
?>
<?php
###################################
$query_sel2 = "SELECT id, n_name, description,  price, dl_count, version FROM Application WHERE id in (SELECT app_id FROM Request WHERE dev_id = '$userID'  and state='$pending')";
#$query_sel2 = "SELECT id, n_name, description,  price, dl_count, version FROM Application WHERE id in (SELECT app_id FROM Request WHERE dev_id = 11  and state='$pending')";
$result2 =  mysqli_query($con,$query_sel2);
$data2 = "";
if (mysqli_num_rows($result2) > 0) {
    // output data of each row
	$data2 .= "<table><tr><th width=\"20%\">Application Name</th>
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
		"</td><td style=\"text-align:center\" width =\"20%\"><a href=\"deleteDevApp.php?ap_id=" . $row2["id"]."\">Delete Application</a></td></tr>";
    }
    $data2 .= "</table>";
} 
else {
    $data2 .= "You don't have any pending apps";
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

		<a class="item" onclick="window.location='developer create.html'">
          <i aria-hidden="true" class="upload icon"></i>
          Add/Update Application
        </a>
		<a class="item" onclick="window.location='index.html';">
		<i aria-hidden="true" class="sign-out icon" ></i>
		Log-out
		</a>
      </div>

      <div class="ui fluid icon input" style=" margin-left:153px; margin-right:2px;">
        <input type="text" placeholder="Search..." />
        <i aria-hidden="true" class="search icon"></i>
      </div>

      <h2 class="ui header" style="margin-left:170px; margin-top:10px;">
        <i class="thumbs up icon"></i>
        <div class="content">
          Approved Apps
        </div>
      </h2>

      <div class="ui stackable four column grid" style="margin-left: 153px; margin-right: 250px;">
    	<div>
			<p><b style="font-size:24px;"></b></p>
			<?=$data?>
		</div>	
      </div>


      <h2 class="ui header" style="margin-left:170px; margin-top:10px;">
        <i class="list icon"></i>
        <div class="content">
           Applications on Consideration
        </div>
      </h2>

      <div class="ui stackable four column grid" style="margin-left: 153px; margin-right: 100px;">
     	<div>
			<p><b style="font-size:24px;"></b></p>
			<?=$data2?>
		</div>	
      </div>



    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

  </body>
</html>
