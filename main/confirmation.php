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
$to      = 'f32ee@localhost';
$subject = 'Booking Confirmation - The BlackSheep Theatre Company';
$message = "Dear ".$_SESSION['customer_login_name'].",
Thank you for making a booking via The BlackSheep Theatre Company. 
This email serves as the confirmation for your recent booking. 

Please find the booking details as follows:";
$headers = 'From: f32ee@localhost' . "\r\n" .
    'Reply-To: f32ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The BlackSheep Theatre Company</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>
    <body>
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
					$index = $j +1;
					$message = $message."
					
".$index.".  ".$show_name." - ".$show_date." ".$show_time."  
Qty: ".$cart_area1." x Area 1;   ".$cart_area2." x Area 2;   ".$cart_area3." x Area 3;   ".$cart_area4." x Area 4;";
				?>
				<table>
					<tr>
						<td><?php echo $show_name; ?> <br>
						<?php echo $show_date; ?><br>
						<?php echo $show_time; ?></td>
						<td><?php echo $cart_area1; ?> x S$60<br><?php echo $cart_area2; ?> x S$45<br><?php echo $cart_area3; ?> x S$35<br><?php echo $cart_area4; ?> x S$20</td>
						<td>Total: <?php echo $total; ?></td>
					</tr>
				</table>
				<?php } ?>
				<?php $message = $message."
				
Thank you for choosing to book with us. We hope to see you soon!
				
Best Regards,
The BlackSheep Theatre Company";
				if (count($_SESSION["cart_item"])>0) {
				mail($to, $subject, $message, $headers,'-ff32ee@localhost');}
				?>
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
<?php unset ($_SESSION["cart_item"]); ?>