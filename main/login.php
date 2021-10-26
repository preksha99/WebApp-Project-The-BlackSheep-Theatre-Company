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
	#var_dump($_SESSION);
}
$id = session_id();
#echo "<br>Session id = $id <br>";

if ($_POST["booking_check"]){
	$password = md5(trim($_POST['password']));
	echo $password;
	$login_query = "SELECT * FROM customers WHERE email='".trim($_POST['email'])."'and password='".$password."'";
	$login_query_result = $db->query($login_query);
	$login_query_num_results = $login_query_result->num_rows;
	echo $login_query_num_results;
	if ($login_query_num_results > 0) {
		$_SESSION['login_email'] = $_POST['email'];
		$_SESSION['password'] = $password;
		?><script type="text/javascript">window.location.href='http://192.168.56.2/f32ee/Project_Latest/bookings.php'; </script>
		<?php
	} else {
?><script type="text/javascript">alert("No account found with the entered email and password!\n" + "Kindly re-enter password or try logging in with another email");</script>
<?php 
	}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The BlackSheep Theatre Company - Login</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
        <style>
          .content img {
            /* margin-left: 10px; */
          }
        </style>
    </head>
    <body>
	<script type = "text/javascript"  src = "js/booking_validation.js" ></script>
  <nav>
                <ul id="nav">
                    <a style="float:left" href="#">
                        <div class="logo-image">
                              <img src="images/logo-image.png" class="img-fluid">
                        </div>
                  </a>
                    <li><a class="active" href="home.html">Home</a>&nbsp;</li>
				    <li><a href="plays.html">Plays</a>&nbsp;<li>
				    <li><a href="contact.html">Contact Us</a>&nbsp;</li>
            
                    <a style="float:right" href="cart.php">
                        <div class="cart-image">
                              <img src="images/cart-image.png" class="img-fluid">
                        </div>
                  </a>
                  <a style="float:right"href="login.php">
                    <div class="bookings-image">
                          <img src="images/bookings.png" class="img-fluid">
                    </div>
                  </a>
                </ul>
            </nav>
			<div id="headingtext">
				GET ALL YOUR <br>BOOKING HISTORY HERE!<p>Simply login using your account!</p>
				<div id="content">
					<img src="images/pastbookings.png" width=450px height=450px align="left" hspace="60px" style="margin-left:220px;">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="retrieve_bookingform">
						<label for="name">Name:</label><br>
						<input type="text" name="name" id="login_name" required style="height: 30px;width :450px;"></input>
						<br><br>
						<label for="phone">Phone Number:</label><br>
						<input type="text" name="phone" id="login_phone" required style="height: 30px;width :450px;"></input>
						<br><br>
						<label for="email">Email:</label><br>
						<input type="email" name="email" id="login_email" required style="height: 30px;width :450px;"></input>
						<br><br>
						<label for="queries">Password:</label><br>
						<input type="password" name="password" id="password" required style="height: 30px;width :450px;"></textarea>
						<br><br><br>
						<input type="reset" value="Reset" class="submitbutton"></input>
						<input type="submit" name="booking_check" value="Login" class="submitbutton"></input>	
					</form>
				<script type = "text/javascript"  src = "js/booking_validation_registry.js" ></script>
				</div>
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
