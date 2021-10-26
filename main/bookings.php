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
$date = date('Y-m-d');
$id = session_id();
#echo "<br>Session id = $id <br>";

$customer_query = "SELECT * FROM customers WHERE email='".trim($_SESSION['login_email'])."';";
$customer_query_result = $db->query($customer_query);
$customer_query_num_results = $customer_query_result->num_rows;
$customer_row=mysqli_fetch_assoc($customer_query_result);
#var_dump($customer_row);
$customer_name = $customer_row["name"];
$customer_id = $customer_row["customerid"];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The BlackSheep Theatre Company - Bookings</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>
    <body>
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
					<li><a class="active" href="login.php">My Bookings</a>&nbsp;</li>
                    <a style="float:right" href="cart.php">
					
                        <div class="cart-image">
                              <img src="images/cart-image.png">
                        </div>
                  </a>
                </ul>
            </nav>
			<div id="headingtext">
				<?php echo "Welcome ".$customer_name; ?>
				<p> Booking History till <?php echo $date; ?></p>
				<div id="content">
				<table>
					<?php $bookings_query = "SELECT * FROM bookings WHERE customerid=".$customer_id.";";
						$bookings_query_result = $db->query($bookings_query);
						$bookings_query_num_results = $bookings_query_result->num_rows;
						while($row=mysqli_fetch_assoc($bookings_query_result)) {
							$bookings_set[] = $row;
						}
						#var_dump($bookings_set);
						
						for ($j=0; $j<count($bookings_set); $j++) {
							#var_dump($bookings_set[$j]);
							$showid = $bookings_set[$j]["showid"];
							#echo $showid."<br>";
							$scheduleid = $bookings_set[$j]["scheduleid"];
							#echo $scheduleid."<br>";
							
							$shows_query = "SELECT * FROM shows WHERE showid=".$showid.";";
							$shows_result = $db->query($shows_query);
							$show_row = mysqli_fetch_assoc($shows_result);
							$show_name = $show_row["name"];
							#echo $show_name."<br>";
							
							$schedule_query = "SELECT * FROM schedule where scheduleid=".$scheduleid.";";
							$schedule_result = $db->query($schedule_query);
							$schedule_row = mysqli_fetch_assoc($schedule_result);
							$schedule_date = DateTime::createFromFormat('Y-m-d H:i:s', $schedule_row["datetime"]);
							$show_date = $schedule_date->format('jS F Y');
							$show_time = $schedule_date->format('h:i a');
							$qty_area1 = $bookings_set[$j]["quantity_area1"];
							$qty_area2 = $bookings_set[$j]["quantity_area2"];
							$qty_area3 = $bookings_set[$j]["quantity_area3"];
							$qty_area4 = $bookings_set[$j]["quantity_area4"];?>					
						<tr>
							<td><?php echo $show_name; ?><br>
							<?php echo $show_date; ?><br>
							<?php echo $show_time; ?></td>
							<td><?php echo $qty_area1; ?> x S$60<br><?php echo $qty_area2; ?> x S$45<br><?php echo $qty_area3; ?> x S$35<br><?php echo $qty_area4; ?> x S$20</td>
						</tr>
<?php } ?>
					</table>
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