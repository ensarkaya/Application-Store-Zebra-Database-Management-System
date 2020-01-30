<?php
include 'connect.php';
session_start();
$column_cardno = array();
$w_id=$_SESSION['id'];

// TODO AÇ ALTTAKİNİ KAPA$query_get_cards = "SELECT card_no FROM Card WHERE w_id = '$_SESSION['$id']'";
$query_get_cards = "SELECT card_no FROM Card WHERE w_id = '$w_id'";
$get_cards_result =  mysqli_query($con,$query_get_cards);

$cnt22= 0;
while($temp89 = mysqli_fetch_array($get_cards_result)){
  $column_cardno[$cnt22] = $temp89;
  $cnt22 = $cnt22 + 1;

}
//$cnt22= 0;
//foreach($column_cardno as $result) {
//    echo $result[$cnt22], '<br>';
//}


if( isset($_POST['load_money_button3']))
{
  header('Location: loadmoney.html');
}

elseif( isset($_POST['add_credit_button3']))
{
  header('Location: addcredit.html');
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
      <i class="credit card icon"></i>
      <div class="content">
        Wallet
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

    <form class="" action="loadmoney.php" method="post">
    <div class="ui placeholder segment" style=" margin-left:200px; margin-right:50px;
    margin-top: 30px  ">
      <div class="ui two column stackable center aligned grid">
        <div class="ui vertical divider">Or</div>
        <div class="middle aligned row">
          <div class="column">
            <div class="ui icon header">
              <i class="credit card icon"></i>
              Add Credit Card
            </div>
            <input type="submit" class="ui primary button" type="submit" value="Add" name="add_credit_button3"  id="add_credit_button2">

          </div>
          <div class="column">
            <div class="ui icon header">
              <i class="lira sign icon"></i>
              Load Money to the Wallet
            </div>
            <input type="submit" class="ui primary button" type="submit" value="Add" name="load_money_button2"  id="load_money_button2">
          </div>
        </div>
      </div>
    </div>
    </form>

<form class="" action="loadmoney.php" method="post">
    <div class="ui right labeled input" style="margin-left: 600px;  margin-top: 50px">
      <label for="amount" class="ui label">₺</label>
      <input type="number" placeholder="Amount" name="amount_to_load" id="amount_to_load">
      <div class="ui basic label">.00</div>
    </div>

<div class="ui middle aligned divided list" style="margin-left: 400px; margin-right: 300px; margin-top: 50px">
    <?php foreach($column_cardno as $key): ?>
        <?php $temp_no_card = $key[0]; '<br>' ?>
            <div class="item">
              <div class="right floated content">
               <input type="submit" class="ui green button" type="submit" value="Load to the card" name="select_card_button"  id="select_card_button">
              </div>
              <i aria-hidden="true" class="credit card icon"></i>
              <div class="content">
                <?php echo $temp_no_card;'<br>'?>
              </div>
            </div>
    <?php endforeach; ?>
</div>
</form>


  <?php
    include 'connect.php';
    if(isset($_POST['select_card_button'])){
      $balance_temp_1 = (int) $_POST['amount_to_load'];
      // TODO: change id in the below line
      $load_with_card = "UPDATE Wallet SET balance = balance + '$balance_temp_1' WHERE id = $w_id";
      $result_of_load_card = mysqli_query($con, $load_with_card);
     }
   ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

  </body>
</html>

<?php

function alert($msg){
  echo "<script type='text/javascript'>
    alert('$msg');
    window.location.href='loadmoney.php';
    </script>";
} ?>