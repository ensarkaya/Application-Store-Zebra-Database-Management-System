<?php
include 'connect.php';
  //in here display the applications of a given category
  //fetch the results and send them to html
  //indexing for category?
  $column_category_id =array();
  $approved="approved";
  $category__name;

  if( isset($_POST['Game']))
  {
      $query_get_games = "SELECT app_id FROM belong_to WHERE c_name = 'Game' AND app_id IN (SELECT app_id FROM Request WHERE state = '$approved')";
      $query_get_games_ids = mysqli_query($con, $query_get_games);
	  $category__name = "GAME";

      $cnt17 = 0;
      while($temp10 = mysqli_fetch_array($query_get_games_ids))
           {
             $column_category_id[$cnt17] = $temp10;
             $cnt17 = $cnt17 + 1;
           }
     //TO DO : IF THE ARRAY IS EMPTY STATE THAT THERE IS NO APPLICATION IN THE GAME CATEGORY

  }
  else if( isset($_POST['Social'])){
      $query_get_socials = "SELECT app_id FROM belong_to WHERE c_name = 'Socials' AND app_id IN (SELECT app_id FROM Request WHERE state = '$approved')";
      $query_get_socials_ids = mysqli_query($con, $query_get_socials);
		$category__name = "SOCIAL NETWORKING";

      $cnt18 = 0;
      while($temp11 = mysqli_fetch_array($query_get_socials_ids))
         {
           $column_category_id[$cnt18] = $temp11;
           $cnt18 = $cnt18 + 1;
         }
   //TO DO : IF THE ARRAY IS EMPTY STATE THAT THERE IS NO APPLICATION IN THE GAME CATEGORY
  }
  else if( isset($_POST['Music'])){
    $query_get_musics = "SELECT app_id FROM belong_to WHERE c_name = 'Musics' AND app_id IN (SELECT app_id FROM Request WHERE state = '$approved')";
    $query_get_musics_ids = mysqli_query($con, $query_get_musics);
		$category__name = "MUSIC";
    $cnt19 = 0;
    while($temp12 = mysqli_fetch_array($query_get_musics_ids))
       {
         $column_category_id[$cnt18] = $temp12;
         $cnt19 = $cnt19 + 1;
       }
  }
  else if( isset($_POST['Education']) ){
    $query_get_educations = "SELECT app_id FROM belong_to WHERE c_name = 'Education' AND app_id IN (SELECT app_id FROM Request WHERE state = '$approved')";
    $query_get_educations_ids = mysqli_query($con, $query_get_educations);
		$category__name = "EDUCATION";
    $cnt20 = 0;
    while($temp13 = mysqli_fetch_array($query_get_educations_ids))
       {
         $column_category_id[$cnt20] = $temp13;
         $cnt20 = $cnt20 + 1;
       }
  }
  else if( isset($_POST['Tools']) ){
    $query_get_tools = "SELECT app_id FROM belong_to WHERE c_name = 'Tools' AND app_id IN (SELECT app_id FROM Request WHERE state = '$approved')";
    $query_get_tools_ids = mysqli_query($con, $query_get_tools);
		$category__name = "TOOLS";
    $cnt21 = 0;
    while($temp14 = mysqli_fetch_array($query_get_tools_ids))
       {
         $column_category_id[$cnt21] = $temp14;
         $cnt21 = $cnt21 + 1;
       }
  }
  else if( isset($_POST['Messaging']) ){
    $query_get_messagings = "SELECT app_id FROM belong_to WHERE c_name = 'Messaging' AND app_id IN (SELECT app_id FROM Request WHERE state = '$approved')";
    $query_get_messagings_ids = mysqli_query($con, $query_get_messagings);
		$category__name = "MESSAGING";
    $cnt22 = 0;
    while($temp15 = mysqli_fetch_array($query_get_messagings_ids))
       {
         $column_category_id[$cnt22] = $temp15;
         $cnt22 = $cnt22 + 1;
       }
  }
  else if( isset($_POST['Dating']) ){
    $query_get_datings = "SELECT app_id FROM belong_to WHERE c_name = 'Education' AND app_id IN (SELECT app_id FROM Request WHERE state = '$approved')";
    $query_get_datings_ids = mysqli_query($con, $query_get_datings);
		$category__name = "DATING";
    $cnt25 = 0;
    while($temp17 = mysqli_fetch_array($query_get_datings_ids))
       {
         $column_category_id[$cnt25] = $temp17;
         $cnt25 = $cnt25 + 1;
       }
  }
  
  
function alert($msg) {
    echo "<script type='text/javascript'>
        alert('$msg');
        window.location.href='developer create.html';
        </script>";
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
	  <a class="item"> <!--maybe add the onclick here-->
          <i aria-hidden="true" class="arrow alternate circle left icon" onclick="window.location='home.php';"></i>
          Back
        </a>
        <a class="item"> <!--maybe add the onclick here-->
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
          <i aria-hidden="true" class="upload icon" onclick="window.location='updates.php';"></i>
          Update
        </a>
      </div>

      <div class="ui fluid icon input" style=" margin-left:153px; margin-right:2px;">
        <form class="" action="search.php" method="post"><!-- get? post?-->
          <input type="text" placeholder="Search..." /> <!-- tipi bozuldu-->
          <i aria-hidden="true" class="search icon"></i>
        </form>
      </div>

      <h2 class="ui header" style="margin-left:170px; margin-top:10px;">
        <i class="eye icon"></i>
        <div class="content">
        <?php echo $category__name;  ?>
         </div>
      </h2>


      <table class="ui inverted blue table" style="margin-left: 170px; margin-right=50px;">
        <thead>
          <tr>
            <th>NAME</th>
            <th>PRICE</th>
            <th>COUNT</th>
            <th> </th>

          </tr>
        </thead>

        <tbody>
          <?php foreach($column_category_id as $key): ?>
            <?php $temp_no_category_id= $key[0]; '<br>' ?>
            <?php
            $query_category_info = "SELECT n_name, price, dl_count FROM Application WHERE id = '$temp_no_category_id'";
            $get_category_info = mysqli_query($con, $query_category_info);


            $value_category_info= mysqli_fetch_object($get_category_info);
            $temp_name_cat = $value_category_info->n_name;
            $temp_price_cat = $value_category_info->price;
            $temp_dl_count_cat = $value_category_info->dl_count;
          ?>
          <tr>
            <td><?php echo $temp_name_cat;'<br>'?></td>
            <td><?php echo $temp_price_cat;'<br>'?></td>
            <td><?php echo $temp_dl_count_cat; '<br>'?></td>
            <td><input type="submit" class="ui green button" type="submit" value="OPEN" name="go_app_from_cat" id="go_app_from_cat">
           
		  
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>





    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

  </body>
</html>
