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
}
$date = date('Y-m-d');
$id = session_id();

$customer_query = "SELECT * FROM customers WHERE email='".trim($_SESSION['login_email'])."';";
$customer_query_result = $db->query($customer_query);
$customer_query_num_results = $customer_query_result->num_rows;
$customer_row=mysqli_fetch_assoc($customer_query_result);
$customer_name = $customer_row["name"];
$customer_id = $customer_row["customerid"];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The BlackSheep Theatre Company - Past Bookings</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
        <style>
            .confirmation-header {
            align-items: center;
            font-family: Montserrat-SemiBold;
            font-size: 35px;
            text-align: center;
            text-decoration: none;
          }
          .confirmation-header .congrats{
            align-items: center;
            font-family: Montserrat-ExtraBold;
            font-size: 55px;
            text-align: center;
            text-decoration: none;
          }
          .booking-details {
              width: 1000px;
              background-color: white;
              margin-left: 230px;
              margin-bottom: 100px;
          }
          .booking-details #statement{
              font-family: Montserrat-SemiBold;
              font-size: 18px;
              margin-left: 40px;
              padding-top: 20px;      
            }
            .row {
                display: flex;
                margin-bottom: 45px;
            }
            .left{
                flex: 35%;
            }
            .left img {
                margin-left: 80px;
            }
            .middle {
                flex: 50%;
            }
            .middle #show-details {
                font-family: Montserrat-SemiBold;
                font-size: 17px;
                text-align: left;
            }
            .show-name {
                font-family: Montserrat-Bold;
                font-size: 35px;
            }
            .right {
                flex: 15%;
            }
            .right #subtotal {
                font-family: Montserrat-SemiBold;
                font-size: 17px;
                text-align: left;
                padding-top: 60px;
            }
            .price {
                font-family: Montserrat-Bold;
                font-size: 20px;
            }
            .total {
                margin-left: 780px;
            }
            .total #total{
                font-family: Montserrat-SemiBold;
                font-size: 20px;
            }
            .total-price {
                font-family: Montserrat-Bold;
                font-size: 30px;
            }
            .confirmation {
                margin-left: 50px;
                padding-top: 10px;
            }
            .confirmation p {
                font-family: Montserrat-Regular;
                font-size: 14px;
            }
            .button {
                margin-left: 15px;
                margin-top: 40px;
                background-color: #292121;
                width:230px;
                height:50px;
            }
            .button a {
                font-family: Montserrat-SemiBold;
                font-style: inherit;
                text-decoration: none;
                font-size: 23px;
                text-align: center;
                color: #FFFFFF;
            }
            .back-button {
                margin-left: 600px;
                margin-bottom: 60px;
            }

        </style>
    </head>
    <body>
            <nav>
                <ul id="nav">
                    <a style="float:left" href="#">
                        <div class="logo-image">
                              <img src="images/logo-image.png" class="img-fluid">
                        </div>
                  </a>
                    <li><a href="index.html">Home</a>&nbsp;</li>
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
			<div class="confirmation-header">
                <p><span class="congrats"><?php echo "Welcome ".$customer_name; ?></span><br>Here is your booking history till <?php echo $date; ?></p>
            </div>
            <div class="booking-details">
                <br><br>
					<?php $bookings_query = "SELECT * FROM bookings WHERE customerid=".$customer_id.";";
						$bookings_query_result = $db->query($bookings_query);
						$bookings_query_num_results = $bookings_query_result->num_rows;
						
						while($row=mysqli_fetch_assoc($bookings_query_result)) {
							$bookings_set[] = $row;
						}
						
						for ($j=0; $j<count($bookings_set); $j++) {
							$showid = $bookings_set[$j]["showid"];
							$scheduleid = $bookings_set[$j]["scheduleid"];
							
							$shows_query = "SELECT * FROM shows WHERE showid=".$showid.";";
							$shows_result = $db->query($shows_query);
							$show_row = mysqli_fetch_assoc($shows_result);
							$show_name = $show_row["name"];
							$show_img = $show_row["images"];
							
							$schedule_query = "SELECT * FROM schedule where scheduleid=".$scheduleid.";";
							$schedule_result = $db->query($schedule_query);
							$schedule_row = mysqli_fetch_assoc($schedule_result);
							$schedule_date = DateTime::createFromFormat('Y-m-d H:i:s', $schedule_row["datetime"]);
							$show_date = $schedule_date->format('jS F Y');
							$show_time = $schedule_date->format('h:i a');
							$qty_area1 = $bookings_set[$j]["quantity_area1"];
							$qty_area2 = $bookings_set[$j]["quantity_area2"];
							$qty_area3 = $bookings_set[$j]["quantity_area3"];
							$qty_area4 = $bookings_set[$j]["quantity_area4"];
							$sub_total = ($qty_area1 * 60) + ($qty_area2* 45) + ($qty_area3 * 35) + ($qty_area4 * 20);
							?>					
			<br><br><br><br>
			<div class="row">
                    <div class="column left">
                        <img src="<?php echo $show_img; ?>" width=166px height=242px align="center">
                    </div>
                    <div class="column middle">
                        <p id="show-details">
                            <span class="show-name"><?php echo $show_name; ?></span><br><br>
                            <?php echo $show_date; ?><br>
                            <?php echo $show_time; ?><br><br><br>
                            <?php echo $qty_area1; ?> x S$60<br>
							<?php echo $qty_area2; ?> x S$45<br>
							<?php echo $qty_area3; ?> x S$35<br>
							<?php echo $qty_area4; ?> x S$20
                        </p>
                    </div>
                    <div class="column right">
                        <p id="subtotal">
                            Subtotal<br>
                            <span class="price">S$<?php echo $sub_total; ?></span>
                        </p>
                    </div>
                </div>
			<?php }?>	
			</div>
			<div class="back-button">
                <button type="button" class="button"><a href="index.html">Back To Home</a></button>
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