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
$date = date('Y-m-d');
$day = date('l');
#echo $day;
#echo $dates;

$id = session_id();
#echo "<br>Session id = $id <br>";

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


if (isset($_GET['del'])) {
	header('location: ' . $_SERVER['PHP_SELF']. '?' . SID);
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
	unset ($_SESSION["cart_item"]); 
}
unset ($_GET['empty']);
#echo '<pre>'.print_r($_SESSION, TRUE).'</pre>';

if ($_POST["login"]){
	$password = md5(trim($_POST['old_password']));
	#echo $password;
	$login_query = "SELECT * FROM customers WHERE email='".trim($_POST['cust_email'])."'and password='".$password."'";
	$login_query_result = $db->query($login_query);
	$login_query_num_results = $login_query_result->num_rows;
	if ($login_query_num_results > 0) {
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

		?><script type="text/javascript">window.location.href='http://192.168.56.2/f32ee/Project_Latest/confirmation.php'; </script>
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
			
			?><script type="text/javascript">window.location.href='http://192.168.56.2/f32ee/Project_Latest/confirmation.php'; </script>
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
        <style>
          .cart-header {
            align-items: center;
            font-family: Montserrat-ExtraBold;
            font-size: 45px;
            text-align: center;
            text-decoration: none;
          }

          .cart-card {
            background-color: white;
            width: 1300px;
            height: 170px;
            margin-left:100px;
            margin-bottom: 45px;
          }

          .row {
            display: flex;
          }
          .left{
                flex: 15%;
            }
          .left img {
            vertical-align: middle;
            margin-left: 30px;
            margin-top: 35px;
          }
            .middle1 {
              flex: 35%;
            }

            .middle1 #heading {
              font-family: Montserrat-Bold;
              font-size: 35px;
              margin-bottom: 15px;
            }

            .body {
              font-family: Montserrat-SemiBold;
              font-size: 17px;
            }
            .middle2 {
              flex: 15%;
            }

            .middle2 p {
              margin-top: 50px;
            }

            .middle2 p #subtotal {
              font-family: Montserrat-Bold;
              font-size: 19px;
            }
            .right {
                flex: 20%;
            }

            .cart-button {
                margin-left: 55px;
                margin-top: 60px;
                background-color: #292121;
                width:160px;
                height:40px;
                font-family: Montserrat-SemiBold;
                font-style: inherit;
                text-decoration: none;
                /* font-weight: 550; */
                font-size: 15px;
                /* line-height: 28px; */
                text-align: center;
                color: #FFFFFF;
            }

            .total button {
              margin-left: 100px;
              margin-top: -20px;
              margin-bottom: 40px;
            }

            .total p {
              margin-left: 950px;
              margin-top: -20px;
              margin-bottom: 40px;
              font-family: Montserrat-SemiBold;
              font-size: 24px;
            }
            .total p #price-text {
              font-family: Montserrat-Bold;
              font-size: 26px;
            }

            .form {
              margin-left: 100px;
              margin-top: 40px;
            }

            .form input[type=text] {
              background: transparent;
              border: none;
              border-bottom: 1px solid #000000;
              padding: 2px 5px;
              margin-bottom: 20px;
            }
			.form input[type=password] {
              background: transparent;
              border: none;
              border-bottom: 1px solid #000000;
              padding: 2px 5px;
              margin-bottom: 20px;
            }

            .form input[type=email] {
              background: transparent;
              border: none;
              border-bottom: 1px solid #000000;
              padding: 2px 5px;
            }

            .form-button {
				margin-left: 550px;
                margin-top: 60px;
                margin-bottom: 40px;
                background-color: #292121;
                width:250px;
                height:40px;
                font-family: Montserrat-SemiBold;
                font-style: inherit;
                text-decoration: none;
                /* font-weight: 550; */
                font-size: 15px;
                /* line-height: 28px; */
                text-align: center;
                color: #FFFFFF;
            }

            .form p {
              font-family: Montserrat-Regular;
              font-size: 15px;
            }
        </style>
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
				<li><a href="login.php">My Bookings</a>&nbsp;</li>
                <a style="float:right" href="cart.php">
                    <div class="cart-image">
                          <img src="images/cart-image.png">
                    </div>
              </a>
            </ul>
        </nav>
        <div class="cart-header">
          CART
        </div>
        <br><br>
		<?php if (count($_SESSION['cart_item']) > 0) {
		?>
        <div class="cart-items">
				<?php $total_cost = 0;
				for ($j=0; $j<count($_SESSION["cart_item"]); $j++){ 
					$show_name = $shows_set[$_SESSION["cart_item"][$j]["showid"]]["name"];
					$show_img = $shows_set[$_SESSION["cart_item"][$j]["showid"]]["images"];
					$show_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $schedule_set[$_SESSION["cart_item"][$j]["scheduleid"]]["datetime"]);
					$show_date = $show_datetime->format('jS F Y , l');
					$show_time = $show_datetime->format('h:i a');
					$cart_area1 = $_SESSION["cart_item"][$j]["quantity_area1"];
					$cart_area2 = $_SESSION["cart_item"][$j]["quantity_area2"];
					$cart_area3 = $_SESSION["cart_item"][$j]["quantity_area3"];
					$cart_area4 = $_SESSION["cart_item"][$j]["quantity_area4"];
					$sub_total = ($cart_area1 * 60) + ($cart_area2* 45) + ($cart_area3 * 35) + ($cart_area4 * 20);
					$total_cost = $total_cost + $sub_total;
				?>
          <div class="cart-card">
            <div class="row">
              <div class="column left">
                <img src="<?php echo $show_img; ?>" width=88px height=110px align="center">
              </div>
              <div class="column middle1">
                <p id="heading"><?php echo $show_name; ?></p>
                <p class="body"><?php echo $show_date;?></p>
                <p class="body"><?php echo $show_time; ?></p>
              </div>
              <div class="column middle2">
                <p class="body">
                  <?php echo $cart_area1; ?> x S$60
                  <br>
                  <?php echo $cart_area2; ?> x S$45
				  <br>
                  <?php echo $cart_area3; ?> x S$35
				  <br>
                  <?php echo $cart_area4; ?> x S$20
                </p>
              </div>
              <div class="column middle2">
                <p class="body">Subtotal<br><br><span id="subtotal">S$<?php echo $sub_total; ?></span></p>
              </div>
              <div class="column right">
				<button class="cart-button"><a href="<?php echo $_SERVER['PHP_SELF'].'?del='.$j;?>" style="color: #ffffff; text-decoration:none;">Remove Item</a></button>
              </div>
            </div>
          </div>
				<?php } ?>
            
          </div>
        </div>
        <div class="total">
          <div class="row">
            <button class="cart-button"><a href="<?php echo $_SERVER['PHP_SELF'].'?empty=1'; ?>" id="empty" value=0 style="color: #ffffff; text-decoration:none;">Clear Cart</a></button>
            <p>Total: <span id="price-text">S$<?php echo $total_cost; ?></span></p>
          </div>
        </div>
        <div class="form">
			<p style="font-size:30px;font-family: Montserrat-SemiBold;"><strong>Key in information to make booking</strong></p><br>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="loginform">
						<label for="cust_name">*Name:</label>
						<input type="text" name="cust_name" id="cust_name" required style="height: 30px;width :500px;"></input><br><br>
						<label for="cust_phone">*Phone Number:</label>
						<input type="text" name="cust_phone" id="cust_phone" required style="height: 30px;width :425px;"></input><br><br>
						<label for="cust_email">*Email:</label>
						<input type="text" name="cust_email" id="cust_email" required style="height: 30px;width:510px;"></input><br><br>
						Have you made a booking with us before?
						<label><input type="radio" name="membership" id="yes_member" value="1" required onclick="showMember_nonMember()">Yes</input></label>
						<label><input type="radio" name="membership" id="no_member" value="0" required onclick="showMember_nonMember()">No</input></label><br><br><br>
						<div id="not_a_member" style="display: none;">
							<label>*Enter Password:</label><input type="password" name="new_password" id="new_password" style="height: 30px;width:430px;"></input><br>
							<label>*Confirm Password:</label><input type="password" name="confirm_password" id="confirm_password" style="height: 30px;width:410px;"></input><br>
							<p>*An email confirmation will be sent on successful payment.</p>
							<input type="submit" name="new_account" id="new_account" value="Create Account & Checkout" class="form-button"></input>
						</div>
						<div id="yes_a_member" style="display: none;">
							<label>*Enter Password:</label><input type="password" name="old_password" id="old_password"style="height: 30px;width:430px;"></input><br>
							<p>*An email confirmation will be sent on successful payment.</p>
							<input type="submit" name="login" id="login" value="Login & Checkout" class="form-button"></input>
						</div>
						<br><br>
					</form>
          <script type = "text/javascript"  src = "js/cart_information_validation.js" ></script>
		<?php } else {?>
			<div class="cart-header" style="font-size:30px;">
			<br><br><br>Cart is Empty <br><br><br><br><br><br>
			</div>
		<?php } ?>
        </div>
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