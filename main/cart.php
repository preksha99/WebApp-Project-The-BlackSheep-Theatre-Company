<?php
@ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }
date_default_timezone_set('Asia/Singapore');
if (!isset($_SESSION))  {
	session_start();
	if (!isset($_SESSION['cart_item'])){
		$_SESSION['cart_item'] = array();
	}
	#unset($_SESSION["cart"]);
	#var_dump($_SESSION);
}
$id = session_id();
echo "<br>Session id = $id <br>";

$shows_query = "SELECT * FROM shows";
$shows_result = $db->query($shows_query);
$shows_num = $shows_result->num_rows;
while($row=mysqli_fetch_assoc($shows_result)) {
				#echo '<pre>'; print_r($row); echo '</pre>'; 
				$shows_set[$row["showid"]] = $row;
}

$schedule_query = "SELECT * FROM schedule";
$schedule_result = $db->query($schedule_query);
$schedule_num = $schedule_result->num_rows;
while($row=mysqli_fetch_assoc($schedule_result)) {
				#echo '<pre>'; print_r($row); echo '</pre>'; 
				#echo ($row["showid"]);
				$schedule_set[$row["scheduleid"]] = $row;
}

if (isset($_GET['del'])) {
	#$_SESSION['cart'][] = $_GET['buy'];
	#echo $_SESSION['cart'];
	header('location: ' . $_SERVER['PHP_SELF']. '?' . SID);
	$update_query = "UPDATE schedule SET quantity_area1 = quantity_area1+".$_SESSION["cart_item"][$_GET["del"]]["quantity_area1"].", quantity_area2 = quantity_area2+".$_SESSION["cart_item"][$_GET["del"]]["quantity_area2"].", 
	quantity_area3 = quantity_area3+".$_SESSION["cart_item"][$_GET["del"]]["quantity_area3"].", quantity_area4= quantity_area4+".$_SESSION["cart_item"][$_GET["del"]]["quantity_area4"]." 
	WHERE showid=".$_SESSION["cart_item"][$_GET["del"]]["showid"]. " and scheduleid=".$_SESSION["cart_item"][$_GET["del"]]["scheduleid"].";";
	$update_result = $db->query($update_query);
	if ($_GET["del"] == (count($_SESSION["cart_item"])-1)) {
		unset ($_SESSION["cart_item"][$_GET["del"]]); 
	}else {
		for ($x=$_GET["del"]; $x<count($_SESSION["cart_item"]); $x++) {
			$_SESSION["cart_item"][$x] = $_SESSION["cart_item"][$x+1]; 
		}
		unset ($_SESSION["cart_item"][(count($_SESSION["cart_item"]))-1]);
	}	
	exit();
	
}
unset ($_GET['del']);

if (isset($_GET['empty'])) {
	header('location: ' . $_SERVER['PHP_SELF']. '?' . SID);
	for ($j=0; $j<count($_SESSION["cart_item"]); $j++){ 
		$showid = $_SESSION["cart_item"][$j]["showid"];
		$scheduleid = $_SESSION["cart_item"][$j]["scheduleid"];
		$update_query = "UPDATE schedule SET quantity_area1 = quantity_area1+".$_SESSION["cart_item"][$j]["quantity_area1"].", quantity_area2 = quantity_area2+".$_SESSION["cart_item"][$j]["quantity_area2"].", 
		quantity_area3 = quantity_area3+".$_SESSION["cart_item"][$j]["quantity_area3"].", quantity_area4= quantity_area4+".$_SESSION["cart_item"][$j]["quantity_area4"]." WHERE showid=".$showid. " and scheduleid=".$scheduleid.";";
		$update_result = $db->query($update_query);
	}
	unset ($_SESSION["cart_item"]); 
}
unset ($_GET['empty']);
#echo '<pre>'; print_r($schedule_set); echo '</pre>'; 
#echo $schedule_num."<br>";
#echo '<pre>'; print_r($shows_set); echo '</pre>';
#echo $shows_num;
echo '<pre>'.print_r($_SESSION, TRUE).'</pre>';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The BlackSheep Theatre Company</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>
    <body>
	<script type = "text/javascript"  src = "js/contact_validation.js" ></script>
            <nav>
                <ul id="nav">
                    <a style="float:left" href="#">
                        <div class="logo-image">
                              <img src="images/logo-image.png">
                        </div>
                  </a>
                    <li><a href="home.html">Home</a>&nbsp;</li>
				    <li><a href="plays.html">Plays</a>&nbsp;<li>
				    <li><a href="contact.html">Contact Us</a>&nbsp;</li>
                    <a style="float:right" href="cart.php" class="active">
                        <div class="cart-image">
                              <img src="images/cart-image.png">
                        </div>
                  </a>
                </ul>
            </nav>
			<div id="content">
				<?php for ($j=0; $j<count($_SESSION["cart_item"]); $j++){ 
					$show_name = $shows_set[$_SESSION["cart_item"][$j]["showid"]]["name"];
					$show_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $schedule_set[$_SESSION["cart_item"][$j]["scheduleid"]]["datetime"]);
					$show_date = $show_datetime->format('jS F Y');
					$show_time = $show_datetime->format('h:i a');
					$cart_area1 = $_SESSION["cart_item"][$j]["quantity_area1"];
					$cart_area2 = $_SESSION["cart_item"][$j]["quantity_area2"];
					$cart_area3 = $_SESSION["cart_item"][$j]["quantity_area3"];
					$cart_area4 = $_SESSION["cart_item"][$j]["quantity_area4"];
					$total = ($cart_area1 * 60) + ($cart_area2* 45) + ($cart_area3 * 35) + ($cart_area4 * 20);
				?>
				<table>
					<tr>
						<td><?php echo $show_name; ?> <br>
						<?php echo $show_date; ?><br>
						<?php echo $show_time; ?></td>
						<td><?php echo $cart_area1; ?> x S$60<br><?php echo $cart_area2; ?> x S$45<br><?php echo $cart_area3; ?> x S$35<br><?php echo $cart_area4; ?> x S$20</td>
						<td>Total: <?php echo $total; ?></td>
						<td><a href="<?php echo $_SERVER['PHP_SELF'].'?del='.$j; ?>" style="background-color:#000000; color:#ffffff;">Delete Tickets from Cart</a></td>
						<td>
						<?php #echo "<td><a href='" .$_SERVER['PHP_SELF']. '?del=' .$j. "' style="">Delete Item</a></td>"; ?>
					</tr>
				</table>
				<?php } ?>
				<a href="<?php echo $_SERVER['PHP_SELF'].'?empty=1'; ?>" style="background-color:#000000; color:#ffffff;">Empty Cart</a>
			</div>
			<br><br><br><br>
            <footer>
                <a style="float:left" href="#">
                    <div class="logo-image-round">
                          <img src="images/logo-image-round.png">
                    </div>
              </a>
              <div class="contact">
                  <p id="contact-title" style="float:left">Contact Us</p>
                  <br><br>
                  <ul>
                      <li> 
                        <img style="float:left" id="icon-image" src="images/location-image.png">
                        &nbsp;&nbsp;&nbsp;1 Esplanade Dr, Singapore 038981
                      </li>
                      <br>
                      <br>
                      <li> 
                        <img style="float:left" id="icon-image" src="images/phone-image.png">
                        &nbsp;&nbsp;&nbsp;+65 7483 2289
                      </li>
                      <br>
                      <br>
                      <li> 
                        <img style="float:left" id="icon-image" src="images/email-image.png">
                        &nbsp;&nbsp;&nbsp;<a id="contact-email" href="mailto:info@blacksheeptheatre.com">info@blacksheeptheatre.com</a>
                      </li>
                  </ul>
                  <p id="copyright">&copy; 2021 BlackSheep Theatre Company. All Rights Reserved.</p>
              </div>
            </footer>
    </body>
</html>