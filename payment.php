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
      <i class="credit card icon"></i>
      <div class="content">
        Wallet
      </div>
    </h1>

    <div class="ui inverted vertical labeled icon ui overlay left thin visible sidebar menu">
      <a class="item">
        <i aria-hidden="true" class="home icon" onclick="window.location='home.php';"></i>
        Home
      </a>
      <a class="item">
        <i aria-hidden="true" class="credit card icon" onclick="window.location='wallet.php';"></i>
        Wallet
      </a>
      <a class="item">
        <i aria-hidden="true" class="list icon" onclick="window.location='wishlist.php';"></i>
        Wishlist
      </a>
      <a class="item">
        <i aria-hidden="true" class="computer icon" onclick="window.location='devices.php';"></i>
        Device
      </a>
      <a class="item">
        <i aria-hidden="true" class="archive icon" onclick="window.location='purchased.php';"></i>
        Purchased
      </a>
      <a class="item">
        <i aria-hidden="true" class="upload icon" onclick="window.location='update.php';"></i>
        Update
      </a>
	  <a class="item" onclick="window.location='index.html';">
		<i aria-hidden="true" class="sign-out icon" ></i>
		Log-out
		</a>
    </div>

    <form class="" action="" method="post">
    <h3 class="ui dividing header" style="margin-left: 300px; margin-top:50px; margin-right:200px;">Pay from Wallet</h3>
    <div class="ui left action input" style="margin-left: 300px;
    margin-top: 5px">
      <input type="submit" class="ui orange button" type="submit" value="Pay" name="pay_with_wallet_button" id="pay_with_wallet_button">
    </div>
    </form>

    <<?php
    include 'connect.php';
    session_start();
    $userID=$_SESSION['id'];
	$app_id= $_SESSION['tempAppId'];
    if(isset($_POST['pay_with_wallet_button'])){

      $query_get_balance = "SELECT balance FROM Wallet WHERE id = '$userID' ";
      $get_balance_result =  mysqli_query($con,$query_get_balance);

      $value_get_balance = mysqli_fetch_object($get_balance_result);
      $wallet_balance = $value_get_balance->balance;

      // TODO:  Session ekle bebeeee pay buttınona bağlayan
      $query_get_price_of_the_app = "SELECT price FROM Application WHERE id = '$app_id'";
      $get_price_of_the_app_result =  mysqli_query($con,$query_get_price_of_the_app);

      $value_get_price = mysqli_fetch_object($get_price_of_the_app_result);
      $price_application = $value_get_price -> price;

      if($price_application <= $wallet_balance)
      {

        $take_money_from_wallet = "UPDATE Wallet SET balance = balance - $price_application WHERE id = '$userID'";
        $result_of_load_card = mysqli_query($con, $take_money_from_wallet);

        // TODO: change sessioooonooonooononon
        $get_version_of_app_to_add_query = "SELECT version FROM Application WHERE id = '$app_id'";
        $get_version_of_app_to_add_result = mysqli_query($con, $get_version_of_app_to_add_query);
        $get_version_of_app_to_add_object = mysqli_fetch_object($get_version_of_app_to_add_result);
        $version_of_app_add = $get_version_of_app_to_add_object -> version;

        // TODO: iki tane session var alttaaaaaaaaaa
        $insert_app_to_add_owns_query = "INSERT INTO owns(u_id, app_id, user_version) VALUES ('$userID', '$app_id', '$version_of_app_add')";
        $insert_app_to_add_owns_result = mysqli_query($con, $insert_app_to_add_owns_query);
		
		$app_update = "UPDATE Application SET dl_count = dl_count + 1 WHERE id='$app_id'";
        mysqli_query($con, $app_update);

        if ($stmt = $con->prepare("DELETE FROM add_wish WHERE app_id = '$app_id'")) {
          $stmt->bind_param('s', $_POST['pay_with_wallet_button']);
          $stmt->execute();
          $stmt->close();
        }

        alert2("Successfully paid!");

      }
      else {
        alert("Balance of wallet is not enough!");
      }

    }
    function alert($msg){
      echo "<script type='text/javascript'>
        alert('$msg');
        window.location.href='payment.php';
        </script>";
    }
     ?>




    <?php
    include 'connect.php';

    $column_cardno_pay = array();

    $query_get_cards_pay = "SELECT card_no FROM Card WHERE w_id = '$userID' ";
    $get_cards_result_pay =  mysqli_query($con,$query_get_cards_pay);

    $cnt8= 0;
    while($temp97 = mysqli_fetch_array($get_cards_result_pay)){
      $column_cardno_pay[$cnt8] = $temp97;
      $cnt8 = $cnt8 + 1;

    }
    ?>

    <form class="" action="" method="post">
    <div class="ui middle aligned divided list" style="margin-left: 300px; margin-right: 300px;
    margin-top: 30px">
      <h3 class="ui dividing header">Pay with Saved Credit Card Information</h3>

      <?php foreach($column_cardno_pay as $key): ?>
        <?php $temp_no_card_pay= $key[0]; '<br>' ?>
      <div class="item">
        <div class="right floated content">
          <input type="submit" class="ui green button" type="submit" value="Pay with this card" name="pay_with_saved_card_button" id="pay_with_saved_card_button">
        </div>
        <i aria-hidden="true" class="credit card icon"></i>
        <div class="content">
          <?php echo $temp_no_card_pay;'<br>'?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    </form>


    <?php
      include 'connect.php';
      if(isset($_POST['pay_with_saved_card_button'])){

        // TODO: change sessioooonooonooononon
        $get_version_of_app_to_add_query = "SELECT version FROM Application WHERE id = '$app_id'";
        $get_version_of_app_to_add_result = mysqli_query($con, $get_version_of_app_to_add_query);
        $get_version_of_app_to_add_object = mysqli_fetch_object($get_version_of_app_to_add_result);
        $version_of_app_add = $get_version_of_app_to_add_object -> version;

        // TODO: iki tane session var alttaaaaaaaaaa
        $insert_app_to_add_owns_query = "INSERT INTO owns(u_id, app_id, user_version) VALUES ('$userID', '$app_id', '$version_of_app_add')";
        $insert_app_to_add_owns_result = mysqli_query($con, $insert_app_to_add_owns_query);
		
		$app_update = "UPDATE Application SET dl_count = dl_count + 1 WHERE id='$app_id'";
        mysqli_query($con, $app_update);

//// TODO:
        if ($stmt = $con->prepare("DELETE FROM add_wish WHERE app_id = '$app_id'")) {
          $stmt->bind_param('s', $_POST['pay_with_saved_card_button']);
          $stmt->execute();
          $stmt->close();
        }


        alert2("Payment is Successfully completed!");
       }
     ?>




    <form action="" class="ui form" method="post" style="margin-left: 300px; margin-right: 200px; margin-top: 20px;">
      <h3 class="ui dividing header">Pay with Unsaved Credit Card</h3>

      <div class="field">
        <label>Name on the Card</label>
        <div class="field">
          <input type="text" name="card_name_payment" placeholder="Name">
        </div>
      </div>

      <div class="field">
        <label>Card Type</label>
        <select class="ui fluid search dropdown" name="card_type_payment">
          <option value="">Type</option>
          <option value="visa">Visa</option>
          <option value="paypal">Paypal</option>
          <option value="mastercard">Master Card</option>
          <option value="american">American Express</option>

        </select>
      </div>

      <div class="fields">
        <div class="seven wide field">
          <label>Card Number</label>
          <input type="text" name="card_number_payment" maxlength="16" minlength="16" placeholder="Card #">
        </div>
        <div class="three wide field">
          <label>CVC</label>
          <input type="text" name="card_cvc_payment" minlength= "3" maxlength="3" placeholder="CVC">
        </div>
        <div class="six wide field">
          <label>Expiration</label>
          <div class="two fields">
            <div class="field">
              <select class="ui fluid search dropdown" name="card_expire-month_payment">
                <option value="">Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
            </div>
            <div class="field">
              <input type="text" name="card_expire-year_payment"  minlength="4" maxlength="4" placeholder="Year">
            </div>
          </div>
        </div>
      </div>
      <input type="submit" class="ui blue button" type="submit" value="Pay" name="pay_new_card_wallet_button" id="pay_new_card_wallet_button">
    </form>

    <?php
    include 'connect.php';
    if(isset($_POST['pay_new_card_wallet_button']))
    {
      if($_POST['card_name_payment'] == "" || $_POST['card_type_payment'] == "" || $_POST['card_number_payment'] == "" || $_POST['card_cvc_payment'] == "" ||
      $_POST['card_expire-month_payment'] == "" || $_POST['card_expire-year_payment'] == ""){
        alert("Please fill all the fields!");
      }
      // TODO: change sessioooonooonooononon
      $get_version_of_app_to_add_query = "SELECT version FROM Application WHERE id = 8";
      $get_version_of_app_to_add_result = mysqli_query($con, $get_version_of_app_to_add_query);
      $get_version_of_app_to_add_object = mysqli_fetch_object($get_version_of_app_to_add_result);
      $version_of_app_add = $get_version_of_app_to_add_object -> version;

      // TODO: iki tane session var alttaaaaaaaaaa
      $insert_app_to_add_owns_query = "INSERT INTO owns(u_id, app_id, user_version) VALUES ('$userID', 8, '$version_of_app_add')";
      $insert_app_to_add_owns_result = mysqli_query($con, $insert_app_to_add_owns_query);
	  
		$app_update = "UPDATE Application SET dl_count = dl_count + 1 WHERE id='$app_id'";
        mysqli_query($con, $app_update);	  

      if ($stmt = $con->prepare("DELETE FROM add_wish WHERE app_id = '$app_id'")) {
        $stmt->bind_param('s', $_POST['card_name_payment']);
        $stmt->execute();
        $stmt->close();
      }


      alert2("The payment is completed!");

    }

    // TODO: bu ilerde php olabilir alttaki
    function alert2($msg){
      echo "<script type='text/javascript'>
        alert('$msg');
        window.location.href='application.php';
        </script>";
    }

    ?>






    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

  </body>
</html>
