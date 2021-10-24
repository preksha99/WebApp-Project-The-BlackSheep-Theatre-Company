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
	var_dump($_SESSION);
}
$date = date('Y-m-d');
echo $date;

function confirm($confirm_msg){
	#echo("<script type='text/javascript'> var confirmation = confirm('".$confirm_msg."'); </script>");
	#$answer = "<script type='text/javascript'>confirmation;</script>";
	#$answer2 = $answer;
?>
<script type="text/javascript">
var confirmation = confirm("<?php echo $confirm_msg; ?>");
document.write(confirmation)
if (confirmation==true) {
	/*window.location.href='http://192.168.56.2/f32ee/Project_Update/cart.php?confirmed=1';*/
	document.getElementById("confirmation").submit();
}
/*var str_confirmation = "confirmation="+confirmation;
document.write(str_confirmation);
document.cookie = str_confirmation;*/
</script>
<?php $confirmation = $_GET['confirmed'];
echo "confirmation =".$confirmation;
return 0;
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
				$schedule_set[$row["scheduleid"]] = $row;
}
if (isset($_SESSION))  {
?>
<script type="text/javascript">
	/*var set_var = false;*/
</script>
<?php
} ?>
<script type="text/javascript">
/*window.addEventListener('beforeunload', function(e) {
  if(set_var) {
    //following two lines will cause the browser to ask the user if they
    //want to leave. The text of this dialog is controlled by the browser.
    e.preventDefault(); //per the standard
    e.returnValue = '0'; //required for Chrome
	var empty_cond = 1;
  }
  //else: user is allowed to leave without a warning dialog
});*/
</script>
<?php
if (isset($_GET['del'])) {
	#$_SESSION['cart'][] = $_GET['buy'];
	#echo $_SESSION['cart'];
	header('location: ' . $_SERVER['PHP_SELF']. '?' . SID);
	#$update_query = "UPDATE schedule SET quantity_area1 = quantity_area1+".$_SESSION["cart_item"][$_GET["del"]]["quantity_area1"].", quantity_area2 = quantity_area2+".$_SESSION["cart_item"][$_GET["del"]]["quantity_area2"].", 
	#quantity_area3 = quantity_area3+".$_SESSION["cart_item"][$_GET["del"]]["quantity_area3"].", quantity_area4= quantity_area4+".$_SESSION["cart_item"][$_GET["del"]]["quantity_area4"]." 
	#WHERE showid=".$_SESSION["cart_item"][$_GET["del"]]["showid"]. " and scheduleid=".$_SESSION["cart_item"][$_GET["del"]]["scheduleid"].";";
	#$update_result = $db->query($update_query);
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

if ($_GET['empty']==1) {
	header('location: ' . $_SERVER['PHP_SELF']. '?' . SID);
	/*
	for ($j=0; $j<count($_SESSION["cart_item"]); $j++){ 
		$showid = $_SESSION["cart_item"][$j]["showid"];
		$scheduleid = $_SESSION["cart_item"][$j]["scheduleid"];
		$update_query = "UPDATE schedule SET quantity_area1 = quantity_area1+".$_SESSION["cart_item"][$j]["quantity_area1"].", quantity_area2 = quantity_area2+".$_SESSION["cart_item"][$j]["quantity_area2"].", 
		quantity_area3 = quantity_area3+".$_SESSION["cart_item"][$j]["quantity_area3"].", quantity_area4= quantity_area4+".$_SESSION["cart_item"][$j]["quantity_area4"]." WHERE showid=".$showid. " and scheduleid=".$scheduleid.";";
		$update_result = $db->query($update_query);
	}*/
	unset ($_SESSION["cart_item"]); 
}
unset ($_GET['empty']);
echo '<pre>'.print_r($_SESSION, TRUE).'</pre>';

if ($_POST["login"]){
	$password = md5(trim($_POST['old_password']));
	#echo $password;
	$login_query = "SELECT * FROM customers WHERE email='".trim($_POST['cust_email'])."'and password='".$password."'";
	$login_query_result = $db->query($login_query);
	$login_query_num_results = $login_query_result->num_rows;
	if ($login_query_num_results > 0) {
		#$confirm_msg = "Thank you for the information! Would you like to proceed with the booking?";
		#$confirmation = confirm($confirm_msg);
		#var_dump($confirmation);
		#var_dump($answer);
		#echo (strpos($confirmation, "true"));
		?><script type="text/javascript">alert("Thank you for your details! Your booking is confirmed.\n" + "You will now be redirected to confirmation page!");</script>
<?php
		$customer_query = "SELECT customerid FROM customers WHERE email='".trim($_POST['cust_email'])."'";
		$customer_query_result = $db->query($customer_query);
		$customer_row=mysqli_fetch_assoc($customer_query_result);
		$customerid = $customer_row['customerid'];
		
		for ($j=0; $j<count($_SESSION["cart_item"]); $j++){ 
			$showid = $_SESSION["cart_item"][$j]["showid"];
			$scheduleid = $_SESSION["cart_item"][$j]["scheduleid"];
			$update_query = "UPDATE schedule SET quantity_area1 = quantity_area1-".$_SESSION["cart_item"][$j]["quantity_area1"].", quantity_area2 = quantity_area2-".$_SESSION["cart_item"][$j]["quantity_area2"].", 
			quantity_area3 = quantity_area3-".$_SESSION["cart_item"][$j]["quantity_area3"].", quantity_area4= quantity_area4-".$_SESSION["cart_item"][$j]["quantity_area4"]." WHERE showid=".$showid. " and scheduleid=".$scheduleid.";";
			$update_result = $db->query($update_query);
			$order_query = "INSERT into bookings (customerid, showid, scheduleid, quantity_area1, quantity_area2, quantity_area3, quantity_area4, booking_date) values ('".$customerid."', ".$showid.", ".$scheduleid.", ".$_SESSION["cart_item"][$j]["quantity_area1"].", ".$_SESSION["cart_item"][$j]["quantity_area2"].", ".$_SESSION["cart_item"][$j]["quantity_area3"].", ".$_SESSION["cart_item"][$j]["quantity_area1"].", '".$date."');";
			$order_query_result = $db->query($order_query);
		}

		?><script type="text/javascript">window.location.href='http://192.168.56.2/f32ee/Project_Update/confirmation.php'; </script>
		<?php
	} else {
?><script type="text/javascript">alert("No account found with the entered email and password!\n" + "Kindly create an account or re-enter password");</script>
<?php 
	}
}

if ($_POST["new_account"]){
	$password = md5(trim($_POST['new_password']));
	$login_query = "SELECT * FROM customers WHERE email='".trim($_POST['cust_email'])."'";
	$login_query_result = $db->query($login_query);
	$login_query_num_results = $login_query_result->num_rows;
	if ($login_query_num_results > 0) {
		?><script type="text/javascript">alert("An account with the given email exists!\n" + "Kindly login using previously entered password or create an account with different email");</script>
		<?php
	}else {	
		$new_account_query = "INSERT into customers (name, phone, email, password) values ('".trim($_POST['cust_name'])."', '".trim($_POST['cust_phone'])."', '".trim($_POST['cust_email'])."', '".$password."');";
		$new_account_query_result = $db->query($new_account_query);
		if ($new_account_query_result) {
			#$confirm_msg = "An account has been created using the given information. Would like to proceed with the booking?";
			#$confirmation = confirm($confirm_msg);
			#var_dump($confirmation);
			?><script type="text/javascript">alert("Thank you for your details! An account has been created susing the details. Your booking has been confirmed.\n" + "You will now be redirected to confirmation page!");</script>
<?php		
			$customer_query = "SELECT customerid FROM customers WHERE email='".trim($_POST['cust_email'])."'";
			$customer_query_result = $db->query($customer_query);
			$customer_row=mysqli_fetch_assoc($customer_query_result);
			$customerid = (int)$customer_row['customerid'];
			
			for ($j=0; $j<count($_SESSION["cart_item"]); $j++){ 
				$showid = $_SESSION["cart_item"][$j]["showid"];
				$scheduleid = $_SESSION["cart_item"][$j]["scheduleid"];
				$update_query = "UPDATE schedule SET quantity_area1 = quantity_area1-".$_SESSION["cart_item"][$j]["quantity_area1"].", quantity_area2 = quantity_area2-".$_SESSION["cart_item"][$j]["quantity_area2"].", 
				quantity_area3 = quantity_area3-".$_SESSION["cart_item"][$j]["quantity_area3"].", quantity_area4= quantity_area4-".$_SESSION["cart_item"][$j]["quantity_area4"]." WHERE showid=".$showid. " and scheduleid=".$scheduleid.";";
				$update_result = $db->query($update_query);
				$order_query = "INSERT into bookings (customerid, showid, scheduleid, quantity_area1, quantity_area2, quantity_area3, quantity_area4, booking_date) values (".$customerid.", ".$showid.", ".$scheduleid.", ".$_SESSION["cart_item"][$j]["quantity_area1"].", ".$_SESSION["cart_item"][$j]["quantity_area2"].", ".$_SESSION["cart_item"][$j]["quantity_area3"].", ".$_SESSION["cart_item"][$j]["quantity_area1"].", '".$date."');";
				$order_query_result = $db->query($order_query);
			}
			
			?><script type="text/javascript">window.location.href='http://192.168.56.2/f32ee/Project_Update/confirmation.php'; </script>
			<?php
		
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The BlackSheep Theatre Company</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>
    <body>
		<script type = "text/javascript"  src = "js/cart_information.js" ></script>
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
					<span id="countdown" class="timer"></span>
					<script>/*
var seconds = 120;
function secondPassed() {
    var minutes = Math.round((seconds - 30)/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds;  
    }
    document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
    if (seconds == 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = "Buzz Buzz";
    } else {
        seconds--;
    }
}
 
var countdownTimer = setInterval('secondPassed()', 1000);*/
					</script>
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
						
						<?php #echo "<td><a href='" .$_SERVER['PHP_SELF']. '?del=' .$j. "' style="">Delete Item</a></td>"; ?>
					</tr>
				</table>
				<?php } ?>
				<a href="<?php echo $_SERVER['PHP_SELF'].'?empty=1'; ?>" id="empty" value=0 style="background-color:#000000; color:#ffffff;">Empty Cart</a>
				<?php if (count($_SESSION['cart_item']) > 0) {
				?>
				<br><br><strong>Key in information to make booking</strong>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="loginform">
					<label for="cust_name">*Name:</label>
					<input type="text" name="cust_name" id="cust_name" required></input><br><br>
					<label for="cust_phone">*Phone:</label>
					<input type="text" name="cust_phone" id="cust_phone" required></input><br><br>
					<label for="cust_email">*Email:</label>
					<input type="text" name="cust_email" id="cust_email" required></input><br><br>
					Have you made a booking with us before?
					<label><input type="radio" name="membership" id="yes_member" value="1" required onclick="showMember_nonMember()">Yes</input></label>
					<label><input type="radio" name="membership" id="no_member" value="0" required onclick="showMember_nonMember()">No</input></label>
					<div id="not_a_member" style="display: none;">
					<label>*Enter Password:</label><input type="password" name="new_password" id="new_password"></input><br>
					<label>*Confirm Password:</label><input type="password" name="confirm_password" id="confirm_password"></input><br>
					<input type="submit" name="new_account" id="new_account" value="Create Account"></input>
					</div>
					<div id="yes_a_member" style="display: none;">
					<label>*Enter Password:</label><input type="password" name="old_password" id="old_password"></input><br>
					<input type="submit" name="login" id="login" value="Login"></input>
					</div>
				</form>
				<script type = "text/javascript"  src = "js/cart_information_validation.js" ></script>
				<?php } else {?>
				<br><br><strong>CART IS EMPTY</strong>
				<?php } ?>
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