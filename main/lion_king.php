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
	#unset($_SESSION["cart_item"]);
	#var_dump($_SESSION);
}
$id = session_id();
#echo "<br>Session id = $id <br>";

if (isset($_POST["buy"])) {
	$itemArray = array("showid"=>$_POST["showid"], "scheduleid"=>$_POST["scheduleid"], "quantity_area1"=>$_POST['quantity_area1'], 
	"quantity_area2"=>$_POST['quantity_area2'], "quantity_area3"=>$_POST['quantity_area3'], "quantity_area4"=>$_POST['quantity_area4']);
	
	#var_dump ($itemArray);
	if (($_POST['quantity_area1']==0)&&($_POST['quantity_area2']==0)&&($_POST['quantity_area3']==0)&&($_POST['quantity_area4']==0)) {
		$all_zero = true;
	}
	else {$all_zero=false;}
	
	if (!$all_zero) {
		if(!empty($_SESSION["cart_item"])) {
			for ($j=0; $j<count($_SESSION["cart_item"]); $j++) {
				
				if (($_SESSION["cart_item"][$j]["scheduleid"]==$itemArray["scheduleid"]) and ($_SESSION["cart_item"][$j]["showid"]==$itemArray["showid"])) {
					if (($_SESSION["cart_item"][$j]["quantity_area1"] + $itemArray["quantity_area1"]) > 10) {
						$itemArray["quantity_area1"] = 0
					?><script type="text/javascript">alert("You can only book a maximum of 10 tickets of Area 1 per show per transaction.Remaining tickets have been added/exist in cart.");</script>
					<?php }
					else {$_SESSION["cart_item"][$j]["quantity_area1"] = $_SESSION["cart_item"][$j]["quantity_area1"] + $itemArray["quantity_area1"];}
					
					if (($_SESSION["cart_item"][$j]["quantity_area2"] + $itemArray["quantity_area2"]) > 10) {
						$itemArray["quantity_area2"] = 0
					?><script type="text/javascript">alert("You can only book a maximum of 10 tickets of Area 2 per show per transaction. Remaining tickets have been added/exist in cart.");</script>
					<?php }
					else {$_SESSION["cart_item"][$j]["quantity_area2"] = $_SESSION["cart_item"][$j]["quantity_area2"] + $itemArray["quantity_area2"];}
					
					if (($_SESSION["cart_item"][$j]["quantity_area3"] + $itemArray["quantity_area3"]) > 10) {
						$itemArray["quantity_area3"] = 0
					?><script type="text/javascript">alert("You can only book a maximum of 10 tickets of Area 3 per show per transaction. Remaining tickets have been added/exist in cart.");</script>
					<?php }
					else {$_SESSION["cart_item"][$j]["quantity_area3"] = $_SESSION["cart_item"][$j]["quantity_area3"] + $itemArray["quantity_area3"];}
						
					if (($_SESSION["cart_item"][$j]["quantity_area4"] + $itemArray["quantity_area4"]) > 10) {
						$itemArray["quantity_area4"] = 0
					?><script type="text/javascript">alert("You can only book a maximum of 10 tickets of Area 4 per show per transaction. Remaining tickets have been added/exist in cart.");</script>
					<?php }
					else {$_SESSION["cart_item"][$j]["quantity_area4"] = $_SESSION["cart_item"][$j]["quantity_area4"] + $itemArray["quantity_area4"];}
					
					$match = 1;
					break;
				} 
				else {
					unset ($match);
					continue;
				}	
			}
			if (!isset($match)) {
				array_push($_SESSION["cart_item"],$itemArray);
				?><script type="text/javascript">alert("Tickets have been added to cart");</script>
				<?php
			}
		}
		else {
			array_push($_SESSION["cart_item"],$itemArray);
			?><script type="text/javascript">alert("Tickets have been added to cart");</script>
			<?php
		}
	}
	#echo '<pre>'.print_r($_SESSION, TRUE).'</pre>';

	#$update_query = "UPDATE schedule SET quantity_area1 = quantity_area1-".$itemArray["quantity_area1"].", quantity_area2 = quantity_area2-".$itemArray["quantity_area2"].", 
	#quantity_area3 = quantity_area3-".$itemArray["quantity_area3"].", quantity_area4= quantity_area4-".$itemArray["quantity_area4"]." WHERE showid=".$_POST["showid"]. " and scheduleid=".$_POST["scheduleid"].";";
	#$update_result = $db->query($update_query);

	
	$retrieval_query = "SELECT * FROM schedule WHERE showid=".$_POST["showid"]. " and scheduleid=".$_POST["scheduleid"];
	$retrieval_result = $db->query($retrieval_query);
	$retrieved_row=mysqli_fetch_assoc($retrieval_result);
	#echo '<pre>'; print_r($retrieved_row); echo '</pre>';
	
}
unset ($_POST["buy"]);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The BlackSheep Theatre Company - Lion King</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
        <style>
            
            .row {
                display: flex;
            }
            .left{
                flex: 55%;
            }
            .right {
                flex: 45%;
            }

            .left img {
                vertical-align: middle;
                margin-left: 125px;
                margin-bottom: 30px;
            }

            .right p {
                margin: 15px;;
            }

            .right #genre {
                font-family: Montserrat-SemiBold;
			font-size: 20px;
			text-decoration: none; 
            }
            .right #heading {
                font-family: Montserrat-Bold;
			font-size: 50px;
			text-decoration: none; 
            }
            .right #details {
                font-family: Montserrat-Medium;
			font-size: 20px;
			text-decoration: none; 
            }
            .right #category {
                font-family: Montserrat-Bold;
			font-size: 20px;
			text-decoration: none;
            }

            .right #space {
                height: 30px;
            }

            .right #synopsis {
                width: 480px;
                text-align: justify;
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
                /* font-weight: 550; */
                font-size: 23px;
                /* line-height: 28px; */
                text-align: center;
                color: #FFFFFF;
            }

            .reviews{
                background-color: #292121;
                width: screen;
                height: 390px;
            }

            .review-column{
                flex: 33.33%;
            }

            .review-column img {
                vertical-align: middle;
                margin-left: 100px;
                margin-top: 50px;
                margin-bottom: 50px;
            }

            .review-column #review{
                font-family: Montserrat-Regular;
                margin-right: 45px;
			font-size: 20px;
			font-style: italic;
            text-align: center;
            color: #FFFFFF;
            }
            .review-column #byline {
                font-family: Montserrat-Bold;
                margin-right: 45px;
			font-size: 20px;
			font-style: italic;
            text-align: center;
            color: #FFFFFF;
            }

            .review-column #review-box{
                margin-left: 70px;
                width: 300px;
                text-align: center;
            }

            .seating-chart {
                align-items: center;
            }
            .seating-chart #seating {
                font-family: Montserrat-SemiBold;
                margin-top: 40px;
			font-size: 30px;
            text-align: center;
            }

            .seating-chart img {
                vertical-align: middle;
                margin-left: 500px;
                margin-top: 0px;
                margin-bottom: 50px;
            }

            .tickets {
                align-items: center;
            }

            .tickets #available {
                font-family: Montserrat-SemiBold;
                margin-left: 60px;
			font-size: 22px;
            text-align: left;
            }

            .ticket-card {
                background-color: white;
                /* width: screen; */
                height: 165px;
                margin-bottom: 40px;
                /* align-items: center; */
            }

            .ticket-card-header {
                background-color: #E5E5E5;
                height: 40px;
                
            }

            .ticket-card-header #date {
                font-family: Montserrat-SemiBold;
                font-size: 20px;
                margin-left: 55px;
                padding-top: 10px;
            }

            .ticket-card #time {
                font-family: Montserrat-SemiBold;
                font-size: 20px;
                /* text-align: center; */
                margin-left: 55px;
                padding-top: 10px;
            }

            .ticket-column{
                flex: 33.33%;
            }

            .submitbutton {
                margin-left: 55px;
                margin-top: 0px;
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

            .price-qty{
                margin-top: 20px;
                margin-left: 35px;
                margin-bottom: 12px;
            }

            .price-qty label {
                font-family: Montserrat-SemiBold;
                text-decoration: none;
                /* font-weight: 550; */
                font-size: 17px;
                /* line-height: 28px; */
                text-align: center;
                margin-right: 20px;
            }

            .price-qty #quantity_area1,#quantity_area2,#quantity_area3,#quantity_area4 {
                width: 140px;
                height: 32px;
                background-color: #E5E5E5;
                border:none;
                text-align: center;
                font-family: Montserrat-SemiBold;
                text-decoration: none;
                /* font-weight: 550; */
                font-size: 13px;
            }

            .view-button {
                margin-left: 550px;
                margin-bottom: 30px;
                background-color: #292121;
                width:230px;
                height:50px;
                
            }

            .view-button a {
                font-family: Montserrat-SemiBold;
                font-style: inherit;
                text-decoration: none;
                /* font-weight: 550; */
                font-size: 23px;
                /* line-height: 28px; */
                text-align: center;
                color: #FFFFFF;
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
        <br>
        <div class = "playDescription">
            <div class="row">
                <div class="column left">
                    <img src="images/chicago_image1.png" width=572px height=415px align="center">
                    <br>
                    <img src="images/chicago_image2.png" width=572px height=415px align="center">
                </div>
                <div class="column right" >
                  <div id="synopsis">
                    <p id="genre">Musical, Fantasy</p>
                    <p id="heading">The Lion King</p>
                    <p id="details"><span id="category">Director:</span> Julie Taymor</p>
                    <p id="details"><span id="category">Writers:</span> Bob Fosse, Fred Ebb</p>
                    <p id="details"><span id="category">Starring:</span> Bianca Marroquín, Ana Villafañe, Paulo Szot</p>
                    <p id="details"><span id="category">Dates:</span> 16 - 19 November 2021</p>
                    <p id="details"><span id="category">Location:</span> Esplanade Theatre</p>
                    <p id="details"><span id="category">Language:</span> English</p>
                    <p id="details"><span id="category">Running Time:</span> 150 minutes</p>
                  </div>
                  <div id="space"></div>
                  <div id="synopsis">
                    <p id="details">Nightclub sensation Velma (Bianca Marroquín) murders her philandering husband, and Chicago's slickest lawyer, Billy Flynn (Paulo Szot), is set to defend her. But when Roxie (Ana Villafañe) also winds up in prison, Billy takes on her case as well -- turning her into a media circus of headlines. Neither woman will be outdone in their fight against each other and the public for fame and celebrity.</p>
                  </div>
                  <button type="button" class="button"><a href="#A">Get Tickets</a></button>
                </div>
              </div>
        </div>
        <br><br>
        <div class="reviews">
            <div class="row">
                <div class="review-column">
                    <img src="images/4stars.png" height=48px align="center">
                    <div id="review-box">
                        <p id="review">“Ambitious, humane. A production of huge resourcefulness.”</p>
                    <p id="byline">The Independent</p>
                    </div>
                </div>
                <div class="review-column">
                    <img src="images/5stars.png" height=48px align="center">
                    <div id="review-box">
                        <p id="review">“Urgent and important.”</p>
                    <p id="byline">Evening Standard</p>
                    </div>
                </div>
                <div class="review-column">
                    <img src="images/4stars.png" height=48px align="center">
                    <div id="review-box">
                        <p id="review">“Intense visual poetry and a powerful emotional undertow.”</p>
                    <p id="byline">The New York Times</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="seating-chart">
            <p id="seating">Seating Chart</p>
            <img src="images/seating.png" width=500px height=581px align="center">
        </div>
        <div class="tickets">
            <p id="available">Available Tickets</p>
            <a name="A"></a>
			<?php 
				$date = date('Y-m-d H:i:s');
				$query = "SELECT * FROM schedule WHERE schedule.datetime >= '".$date."' and showid=4";
				$result = $db->query($query);
				$num_results = $result->num_rows;
				while($row=mysqli_fetch_assoc($result)) {
					$resultset[] = $row;
				}
				for ($i=0; $i < $num_results; $i++) {
					$show_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $resultset[$i]["datetime"]);
					$show_date = $show_datetime->format('jS F Y , l');
					$show_time = $show_datetime->format('h:i a');
			?>
            <div class="ticket-card">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="ticket-card-header">
                    <p id="date"><?php echo $show_date; ?></p>
                </div>
                <div class="row">
                    <div class="ticket-column">
                        <p id="time"><?php echo $show_time; ?></p>
						<input type="submit" value="Add to Cart" class="submitbutton"></input>
                        
                    </div>
                    <div class="ticket-column">
                        <div class="price-qty">
								<input type="hidden" name="scheduleid" value="<?php echo $resultset[$i]["scheduleid"]; ?>">
								<input type="hidden" name="showid" value="<?php echo $resultset[$i]["showid"]; ?>">
								<input type="hidden" name="buy" value="<?php echo "1"; ?>">
                            <label for="quantity_area1">S$60:</label>
							<select name="quantity_area1" id="quantity_area1">
								<option value=0>0</option>
								<?php if ($resultset[$i]["quantity_area1"]>=10) {
									for ($x=1; $x<=10; $x++) {
								?>
								<option value=<?php echo $x; ?>><?php echo $x; ?></option>
								<?php } }
								if ($resultset[$i]["quantity_area1"]<10) {
									for ($x=1; $x<=$resultset[$i]["quantity_area1"]; $x++) {
								?>
								<option value=<?php echo $x; ?>><?php echo $x; ?></option>
								<?php } } ?>
							</select></div>
							<div class="price-qty">
                            <label for="quantity_area2">S$45:</label>
							<select name="quantity_area2" id="quantity_area2">
								<option value=0>0</option>
								<?php if ($resultset[$i]["quantity_area2"]>=10) {
									for ($x=1; $x<=10; $x++) {
								?>
								<option value=<?php echo $x; ?>><?php echo $x; ?></option>
								<?php } }
								if ($resultset[$i]["quantity_area2"]<10) {
									for ($x=1; $x<=$resultset[$i]["quantity_area2"]; $x++) {
								?>
								<option value=<?php echo $x; ?>><?php echo $x; ?></option>
								<?php } } ?>
							</select></div>
                    </div>
                    <div class="ticket-column">
						<div class="price-qty">
                            <label for="quantity_area3">S$30:</label>
							<select name="quantity_area3" id="quantity_area3">
								<option value=0>0</option>
								<?php if ($resultset[$i]["quantity_area3"]>=10) {
									for ($x=1; $x<=10; $x++) {
								?>
								<option value=<?php echo $x; ?>><?php echo $x; ?></option>
								<?php } }
								if ($resultset[$i]["quantity_area3"]<10) {
									for ($x=1; $x<=$resultset[$i]["quantity_area3"]; $x++) {
								?>
								<option value=<?php echo $x; ?>><?php echo $x; ?></option>
								<?php } } ?>
							</select></div>
						<div class="price-qty">
                            <label for="quantity_area4">S$20:</label>
							<select name="quantity_area4" id="quantity_area4">
								<option value=0>0</option>
								<?php if ($resultset[$i]["quantity_area4"]>=10) {
									for ($x=1; $x<=10; $x++) {
								?>
								<option value=<?php echo $x; ?>><?php echo $x; ?></option>
								<?php } }
								if ($resultset[$i]["quantity_area4"]<10) {
									for ($x=1; $x<=$resultset[$i]["quantity_area4"]; $x++) {
								?>
								<option value=<?php echo $x; ?>><?php echo $x; ?></option>
								<?php } } ?>
							</select></div>
                    </div>
                </div>
				</form>
            </div>
				<?php } ?>
            <button type="button" class="view-button"><a href="cart.php">View Cart</a></button>
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