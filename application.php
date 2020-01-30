
<!-- TODO: i am assuming the application id is given to me in the url
    TODO: premium user
-->
<?php
  include "connect.php";
  session_start();
  //TODO: change all sidebars to item instead of icon
	$ap_id= "";
	if (isset($_GET['ap_id'])) {
		$ap_id = $_GET['ap_id'];
	}
	else{
		$ap_id=$_POST['app_id'];
	}
  $user = $_SESSION['id'];  //TODO: get user id from session
  $app = $ap_id; //TODO: GET THIS FROM THE SESSION/URL
  $sql = "SELECT * FROM Application WHERE id='$app'";
 
  $result = mysqli_fetch_assoc(mysqli_query($con, $sql));
  $name = $result['n_name'];
  $description = $result['description'];
  $ram = $result['min_ram'];
  $price = $result['price'];
  if ($price == 0){
    $price = "Free";
  }
  else{
    $check_premium = "SELECT * FROM Premium_User WHERE id='$user'";
    $check = mysqli_query($con, $check_premium);
    if (mysqli_num_rows($check) > 0){ //user is premium
      $price = $price * (0.20);
    }
  }
  $version = $result['version'];
  $dl_count = $result['dl_count'];
  $rate_query = "SELECT AVG(rate) as avg_rate FROM Review WHERE app_id = '$app'";
  $result =  mysqli_fetch_assoc(mysqli_query($con,$rate_query));
  $rate = $result['avg_rate'];

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

    <div class="ui items" style=" margin-left:200px; margin-right:400px;margin-top: 20px">
      <div class="item">
        <div class="content">
          <a class="header"><?php echo $name;?></a>
          <div class="meta">
            <span></span>
          </div>
          <div class="description">
            <p></p>
            <?php echo $description;?>
            <p></p>
            Rate: <?php echo $rate; ?>
          </div>
          <p></p>
          <div class="extra">
            <br>
            Price: <?php echo $price ;?>
            <br>
            <?php
              $check_owns = "SELECT * FROM owns WHERE u_id='$user' AND app_id='$app'";
              $result =  mysqli_query($con, $check_owns);
                if (mysqli_num_rows($result) == 0): //user did not download the app
                  //check if compatible
                  $compatible = "SELECT * FROM Device D, possess P WHERE P.u_id = '$user' AND D.id = P.dvc_id AND D.ram >= '$ram'";
                  $supported = mysqli_query($con, $compatible); //this is all of the supported devices
                  if(mysqli_num_rows($supported) == 0):
                    echo "No compatible device. Can not process downlaod!";
                  else:
                    $devices = array();
                    while ($row = mysqli_fetch_array($supported)) {
                      $devices[] = $row;
                    }
                    ?>
                    <select class="ui dropdown" name="deviceSel">
                      <option value="">Devices</option>
                      <?php foreach($devices as $device): ?>
                        <option value=""><?php echo $device['n_name']; ?></option>
                      <?php endforeach?>
                    </select>
                  <?php endif ?>

                  <form action="application.php" method="post">
                    <input type="hidden" id="app_id" name="app_id" value="<?php echo $app; ?>">
                    <input type="submit" class="ui green button" type="submit" value="Download" name="download"  id="download">

                    <?php //check wishlist
                      $check_wish = "SELECT * FROM add_wish WHERE u_id='$user' AND app_id='$app'";
                      $result =  mysqli_query($con, $check_wish);
                        if (mysqli_num_rows($result) == 0){ //user did not download the app?>
                          <input type="submit" class="ui blue button" type="submit" value="Add to Wishlist" name="wishlist"  id="wishlist">
                        <?php  }?>
                  </form>
                <?php else: //here user already downloaded the app
                  $query_update = "SELECT A.id, A.n_name, A.description, A.dl_count, A.version, O.user_version FROM Application A, owns O WHERE A.id = '$app' AND A.id = O.app_id AND O.user_version < A.version  AND O.u_id = '$user'";
                  $result =  mysqli_query($con,$query_update);
                  if(mysqli_num_rows($result) > 0) {?>
                    <form action="application.php" method="post">
                      <input type="hidden" id="app_id" name="app_id" value="<?php echo $app; ?>">
                      <input type="submit" class="ui red button" type="submit" value="Update" name="update"  id="update">
                    </form>
                  <?php }
                  else{?>
                    <button class="ui grey button">Downloaded</button>
                <?php } ?>
              <?php endif ?>
          </div>
        </div>
      </div>
    </div>
    <h2 class="ui header" style="margin-left: 200px; margin-top: 50px;">
      <div class="content">
        Description
      </div>
    </h2>
    <h4 class="ui header" style="margin-left: 200px; margin-top: 50px;">
      <?php echo $description; ?>
      <br>
      Version: <?php echo $version; ?>
      <br>
      Size: <?php echo $ram; ?>
      <br>
      Download Count: <?php echo $dl_count; ?>
      <br>

    </h4>

    <?php
    //Get the Comments
    $comments = "SELECT * FROM Review WHERE app_id='$app'";
    $result =  mysqli_query($con,$comments);
    $resultset = array();
    while ($row = mysqli_fetch_array($result)) {
      $resultset[] = $row;
    }

    ?>
    <?php
        if(isset($_POST['download'])){
			$aaap=$_POST['app_id'];
              //given the device exists now check for the Price
              if ($price == "Free"){ //Free
                $app_update = "UPDATE Application SET dl_count = dl_count + 1 WHERE id='$aaap'";
                mysqli_query($con, $app_update);
                $owns_update = "INSERT INTO owns(u_id, app_id) VALUES('$user', '$aaap')";
                mysqli_query($con, $owns_update);
                $wish_delete = "DELETE FROM add_wish WHERE app_id = '$aaap' AND u_id = '$user'";
                mysqli_query($con, $wish_delete);
				alert("burdayım");
              }
              else{
				 $_SESSION['tempAppId'] = $aaap;
				header('Location: payment.php');
              }

            //then send to payment
          }
        if(isset($_POST['wishlist'])){
            //get the user id using the SESSION--$user
            //get the app id using the SESSION-$app
            //update the add_wish table by adding a new relation btw this user and app
			$aaap1=$_POST['app_id'];
			 $wish_query = "INSERT INTO add_wish(u_id, app_id) VALUES('$user', '$aaap1')";
            mysqli_query($con, $wish_query);
            alert2("Application added to wishlist!");
        }

        if(isset($_POST['add'])){
          //get the user id from the session --$user

          //check if the user owns the application
		  $aaap2=$_POST['app_id'];
          $check = "SELECT * FROM owns WHERE u_id='$user' and app_id='$aaap2'";
          $result =  mysqli_query($con,$check);
          if (mysqli_num_rows($result) == 0){ //user did not download the app
            alert2("You can not review an app you did not download!");
          }
          else{ //user owns the app
            //get the rating and comment
            $u_rate = $_POST['rate'];
            $u_comment = $_POST['comment'];
            $add_comment = "INSERT INTO Review(app_id, rate, comment, u_id) VALUES ('$app', '$u_rate', '$u_comment', '$user')";
            mysqli_query($con, $add_comment);
          }
        }

        function alert($msg) {
            echo "<script type='text/javascript'>
                alert('$msg');
                window.location.href='application.php';
                </script>";
        }
		function alert2($msg) {
            echo "<script type='text/javascript'>
                alert('$msg');
                window.location.href='home.php';
                </script>";
        }

  ?>
    <div class="ui comments" style=" margin-left:200px; margin-right:400px;">
      <h3 class="ui dividing header">Comments</h3>
      <?php foreach($resultset as $review): ?>
        <?php
        //Get user_id
        $u_id = $review['u_id']; //CHECK!!

        //Get name of the user
        $name_sql = "SELECT n_name FROM Account WHERE id='$u_id'";
        $name_result = mysqli_fetch_assoc(mysqli_query($con, $name_sql));
         ?>
      <div class="comment">
        <div class="content">
          <a class="author"><?php echo $name_result['n_name']; ?></a>
          <br>
          Rate: <?php echo $review['rate']; ?>
          <div class="text">
            <?php echo $review['comment']; ?>
          </div>

        </div>
      </div>
    <?php endforeach ?>
    <form class="ui form" action="application.php" method="post">
      <div class="ui right labeled input">
        <input type="number" name="rate" placeholder="Rate" max=5 min=1>
        <div class="ui basic label">
          /5
        </div>
      </div>
      <div class="field">
        <textarea type="textarea" name="comment" placeholder="Tell us what you think"></textarea>
      </div>
      <input class="ui blue labeled submit icon button" type="submit" name="add" id="add" value="Add Comment">
	  <input type="hidden" id="app_id" name="app_id" value="<?php echo $app; ?>">
    </form>
  </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

  </body>
</html>
