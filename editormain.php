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
		
		<a class="item" onclick="window.location='index.html';">
		<i aria-hidden="true" class="sign-out icon" ></i>
		Log-out
		</a>
      </div>
      

      <h2 class="ui header" style="margin-left:20px; margin-top:30px;">
        <i class="inbox icon"></i>
        <div class="content">
          Requests
        </div>
      </h2>

      <?php

        include "connect.php";
		session_start();
        //***********$ed_id = $_SESSION['id'];       TODO:ADD THIS LATER
        $ed_id = $_SESSION['id'];
        //get all of the requests that are currently pending
		$pending="pending";
        $sql = "SELECT * FROM Request WHERE state='$pending'";
        $result = mysqli_query($con, $sql);
        $resultset = array();
        while ($row = mysqli_fetch_array($result)) {
          $resultset[] = $row;
        }

        ?>
      <div class="ui divided selection list" style="margin-left:20px; margin-right:100px;">

        <?php foreach($resultset as $request): ?>

          <?php
          //Get request id
          $req_id = $request['id']; //CHECK!!

          //Get app information
          $app_id = $request['app_id'];
          $app_sql = "SELECT n_name, description FROM Application WHERE id='$app_id';";
          $app_result = mysqli_fetch_assoc(mysqli_query($con, $app_sql));


          //Get developer information
          $dev_id = $request['dev_id'];
          $dev_sql = "SELECT name FROM Account WHERE id='$dev_id';";
          //$dev_result = mysqli_fetch_assoc(mysqli_query($con, $dev_sql));
           ?>

        <a class="item">

          <form class="" action="editormain.php" method="post">

          <div class="ui green horizontal label"><?php echo $request['type'];?></div>

            <div class="right floated content">

              <div class="ui buttons">
                <input type="hidden" name="requestId" value="<?php echo $req_id; ?>">
				<input type="hidden" name="appId" value="<?php echo $app_id; ?>">
                <input class="ui positive button" type="submit" name="accept" value="Accept">
                <div class="or"></div>
                <input class="ui negative button" type="submit" name="reject" value="Reject">
              </div>
            </div>
            <br>
            <?php echo $app_result["n_name"];?>
            <br>
            <?php echo $app_result["description"];?>
            <br>
            <?php //$dev_result['name'];?>

            <br>
            <select class="ui dropdown" name="restrictionSel">
              <option value="">Restriction</option>
              <option value="1">General Audience</option>
              <option value="2">Parental Guidance Suggested</option>
              <option value="3">Parents Strongly Cautioned</option>
              <option value="4">Restricted</option>
              <option value="5">Adults Only</option>
            </select>
            <br>

            </form>
        </a>
        <?php endforeach; ?>
      </div>

      <?php
        include 'connect.php';
          if(isset($_POST['accept'])){ //CHANGE THIS FOR ACCEPT & REJECT
              //update the Request table so that the state is 'accepted'
              $request_id = $_POST["requestId"]; //TODO: CHECK
			  $approved="approved";
              $accepted = "UPDATE Request SET state='$approved', e_id='$ed_id' WHERE id='$request_id'";
              mysqli_query($con, $accepted);
              //check if user specified a restriction
              $restriction = $_POST['restrictionSel'];
              if ($restriction != ""){

				$app_id = $_POST['appId'];
                //update the contains table with the specified restriction
                $contains = "INSERT INTO contains(r_id, app_id) VALUES ('$restriction','$app_id')";
                mysqli_query($con, $contains); //TODO:check
				alert($x);
              }
              
            }
          if(isset($_POST['reject'])){ //CHANGE THIS FOR ACCEPT & REJECT
                //update the Request table so that the state is 'rejected'
                $request_id = $_POST["requestId"]; //TODO: CHECK
				$rejected="rejected";
                $rejected = "UPDATE Request SET state='$rejected', e_id='$ed_id' WHERE id='$request_id'";
                mysqli_query($con, $rejected);
                alert("Request Rejected!");

            }


            function alert($msg) {
                echo "<script type='text/javascript'>
                    alert('$msg');
                    window.location.href='editormain.php';
                    </script>";
            }

 ?>


    </div>



  </body>
</html>
