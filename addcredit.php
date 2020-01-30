<?php
include 'connect.php';
session_start();
$userID = $_SESSION['id'];

if( isset($_POST['load_money_button2']))
{
  header('Location: loadmoney.php');
}

elseif( isset($_POST['add_credit_button2']))
{
  header('Location: addcredit.html');
}

else if(isset($_POST['submit_card_button']))
{
  if($_POST['card_name'] == "" || $_POST['card_type'] == "" || $_POST['card_number'] == "" || $_POST['card_cvc'] == "" ||
  $_POST['card_expire-month'] == "" || $_POST['card_expire-year'] == ""){
    alert("Please fill all the fields!");
  }

  else {
    //TODO DÜZELT  TARİHİ
    $dateStr = $_POST['card_expire-month'] + '01' +  $_POST['card_expire-year'];
    $credit_card_date = date($dateStr);

    $credit_card_name = mysqli_real_escape_string($con,$_POST['card_name']);
    $credit_card_type = mysqli_real_escape_string($con,$_POST['card_type']);
    // CARD NUMBER
    if(is_numeric($_POST['card_number']))
    {
      $credit_card_no = (int) $_POST['card_number'];
    }
    else
    {
      alert("The card number should be numeric");  // price is not numeric, fails validation
    }
    // CARD CVC
    if(is_numeric($_POST['card_cvc']))
    {
      $credit_card_cvc = (int) $_POST['card_cvc'];
    }
    else
    {
      alert("The card number should be numeric");  // price is not numeric, fails validation
    }

    $query_check_card_no = "SELECT card_no FROM Card WHERE card_no = '$credit_card_no'";
    $result_of_check_card = mysqli_query($con, $query_check_card_no);
    if(mysqli_num_rows($result_of_check_card)  == 0)
    {
      // TODO wallet id yi şöyle değiştir : '$_SESSION['walletId']'
      $query__7 = "INSERT INTO Card(card_no, bank, n_name, exp_date, sec_no, w_id) VALUES ('$credit_card_no','$credit_card_type','$credit_card_name', '$credit_card_date', '$credit_card_cvc','$userID')";
      mysqli_query($con, $query__7);
      goWallet("Card added");

    }
    else {
      alert("Another card with the same card no exists");
    }
  }
}
function alert($msg){
  echo "<script type='text/javascript'>
    alert('$msg');
    window.location.href='addcredit.html';
    </script>";
}
function goWallet($msg){
  echo "<script type='text/javascript'>
    alert('$msg');
    window.location.href='wallet.php';
    </script>";
}

 ?>
