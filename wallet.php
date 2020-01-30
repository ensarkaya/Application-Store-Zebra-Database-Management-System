<?php
include 'connect.php';
session_start();

$userID =$_SESSION['id'];
$query_get_balance_now = "SELECT balance FROM Wallet WHERE id = '$userID'";
$get_wallet__balance_result_now =  mysqli_query($con,$query_get_balance_now);

$value_wallet_balance_fetch = mysqli_fetch_object($get_wallet__balance_result_now);
$value_wallet_balance = $value_wallet_balance_fetch -> balance;
if( isset($_POST['load_money_button']))
{
  header('Location: loadmoney.php');
}

elseif( isset($_POST['add_credit_button']))
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

     <form class="" action="wallet.php" method="post">
     <div class="ui placeholder segment" style=" margin-left:200px; margin-right:50px;
     margin-top: 30px">
       <div class="ui two column stackable center aligned grid">
         <div class="ui vertical divider">Or</div>
         <div class="middle aligned row">
           <div class="column">
             <div class="ui icon header">
               <i class="credit card icon"></i>
               Add Credit Card
             </div>
             <input type="submit" class="ui primary button" type="submit" value="Add" name="add_credit_button"  id="add_credit_button">
           </div>
           <div class="column">
             <div class="ui icon header">
               <i class="lira sign icon"></i>
               Load Money to the Wallet
             </div>
              <input type="submit" class="ui primary button" type="submit" value="Load" name="load_money_button"  id="load_money_button">
           </div>
         </div>
       </div>
     </div>
     </form>


  <div style="margin-left: 700px; margin-top: 40px; width:250px;height:80px;border:1px  solid #000;">
     <div class="ui statistics" style="margin-left=300px;">
     <div class="statistic">
      <div class="value">
        <i class="lira icon"></i> <?php echo $value_wallet_balance ?>
      </div>
      <div class="label">
        Balance
      </div>
    </div>
    </div>
  </div>


     <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

   </body>
 </html>
