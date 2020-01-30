<?php
include 'connect.php';
session_start();
$u_id=$_SESSION['id'];
$column_devices_ids = array();
$column_device_rams = array();
$column_device_cpus = array();
$column_device_osss = array();

// // TODO: change u_id
$query_get_devices_ids = "SELECT dvc_id FROM possess WHERE u_id = '$u_id'";
$get_device_result_ids = mysqli_query($con, $query_get_devices_ids);

$query_get_device_rams = "SELECT n_name FROM Device WHERE u_id = '$u_id'";
$get_devname_result_ram = mysqli_query($con, $query_get_device_rams);

$query_get_device_cpus = "SELECT n_name FROM Device WHERE u_id = '$u_id'";
$get_devname_result_cpu = mysqli_query($con, $query_get_device_cpus);

$query_get_device_oss = "SELECT n_name FROM Device WHERE u_id = '$u_id'";
$get_devname_result_os = mysqli_query($con, $query_get_device_oss);

$cnt23 = 0;
while($temp20 = mysqli_fetch_array($get_device_result_ids))
     {
       $column_devices_ids[$cnt23] = $temp20;
       $cnt23 = $cnt23 + 1;
     }


if( isset($_POST['add_device']))
{
  if($_POST['device_name'] == "" || $_POST['ram'] == "" || $_POST['cpu'] == "" ||$_POST['os'] == "" ){
    alert("Please fill all the fields");
  }
  else{
	  
    #TO DO: CHECKING IF ALL FIELDS FILLED CORRECTLY
	 if($_POST['device_name'] == "" || $_POST['ram'] == "" || $_POST['cpu'] == "" || $_POST['os'] == ""){
		alert("Please fill all the fields!");
	  }
    $adding_device_name1 = mysqli_real_escape_string($con,$_POST['device_name']);
    $adding_ram1 = mysqli_real_escape_string($con,$_POST['ram']);
    $adding_cpu1 = mysqli_real_escape_string($con,$_POST['cpu']);
    $adding_os1 = mysqli_real_escape_string($con,$_POST['os']);
    $query_device1 = "INSERT INTO  Device(n_name, ram, cpu, os) VALUES ('$adding_device_name1', '$adding_ram1', '$adding_cpu1', '$adding_os1')";
    mysqli_query($con, $query_device1);


    #TO DO: CHANGE USER_ID VALUE TO '$_SESSION['id']'
    $device_id_query = "SELECT id FROM Device where ram = '$adding_ram1' AND cpu = '$adding_cpu1' AND n_name = '$adding_device_name1' AND os = '$adding_os1' limit 1";
    $device_id_add_sql = mysqli_query($con, $device_id_query);


    $value_device_id_add= mysqli_fetch_object($device_id_add_sql);
    $device_id_add = $value_device_id_add->id;
    $query_add_device_to_possess = "INSERT INTO possess(u_id, dvc_id, n_name) VALUES('$u_id', '$device_id_add', '$adding_device_name1')";
    mysqli_query($con, $query_add_device_to_possess);


    #$editor_id = "SELECT id FROM Account where email = '$adding_editor_email1'
    #$query_add_editor = "INSERT INTO Editor(id, adm-id) VALUES('$editor_id', '$_SESSION['id']')"
    alert("Successfully added");
  }
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
      <i class="computer icon"></i>
      <div class="content">
        Devices
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
    <table class="ui celled table" style="margin-left: 170px; right: 100px;">
      <thead>
        <tr><th>Device Name</th>
        <th>RAM</th>
        <th>CPU</th>
        <th>OS</th>
      </tr></thead>


      <?php foreach ($column_devices_ids as $key1):  ?>
        <?php
        $temp_no_device = $key1[0]; '<br>' ?>
        <?php
        include 'connect.php';
        $query_devices_info = "SELECT n_name, ram, cpu, os FROM Device WHERE id = '$temp_no_device'";
        $get_device_info = mysqli_query($con, $query_devices_info);
        $value_device_info= mysqli_fetch_object($get_device_info);
        $temp_name_dev = $value_device_info->n_name;
        $temp_ram_dev = $value_device_info->ram;
        $temp_cpu_dev = $value_device_info->cpu;
        $temp_os_dev = $value_device_info->os;
         ?>
        <tbody>
          <tr>
            <td data-label="Device Name"><?php echo $temp_name_dev;'<br>'?></td>
            <td data-label="RAM"><?php echo $temp_ram_dev;'<br>'?></td>
            <td data-label="CPU"><?php echo $temp_cpu_dev;'<br>'?></td>
            <td data-label="OS"><?php echo $temp_os_dev;'<br>'?></td>
          </tr>
        </tbody>

      <?php endforeach; ?>


    </table>
    <h2 class="ui header" style="margin-left: 200px; margin-top: 70px;">
      <div class="content">
        Add Device
      </div>
    </h2>

      <form class="" action="devices.php" method="post">

      <div class="ui large form" style="margin-left: 200px; margin-right: 100px;">
      <div class="four fields">
        <div class="field">
          <label>Device Name</label>
          <input placeholder="Device Name" type="text" name="device_name" maxlength="30" >
        </div>
        <div class="field">
          <label>RAM</label>
          <input placeholder="RAM" type="number" name="ram">
        </div>
        <div class="field">
          <label>CPU</label>
          <input placeholder="CPU" type="text" name="cpu" maxlength="30">
        </div>
        <div class="field">
          <label>OS</label>
          <input placeholder="OS" type="text" name = "os" maxlength="30">
        </div>
      </div>
      <input type="submit" class="ui submit right floated large positive button" value="Add" name="add_device" id="add_device">
    </div>
          </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
  </body>
</html>

<?php
function alert($msg){
  echo "<script type='text/javascript'>
    alert('$msg');
    window.location.href='devices.php';
    </script>";
}
 ?>