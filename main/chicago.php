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
	var_dump($_SESSION);
}
$id = session_id();
echo "<br>Session id = $id <br>";

if (isset($_POST["buy"])) {
	$itemArray = array("showid"=>$_POST["showid"], "scheduleid"=>$_POST["scheduleid"], "quantity_area1"=>$_POST['quantity_area1'], 
	"quantity_area2"=>$_POST['quantity_area2'], "quantity_area3"=>$_POST['quantity_area3'], "quantity_area4"=>$_POST['quantity_area4']);
	
	if(!empty($_SESSION["cart_item"])) {
		echo "  Not empty";
		for ($j=0; $j<count($_SESSION["cart_item"]); $j++) {
			echo "  Inside loop".$j;
			
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
	echo '<pre>'.print_r($_SESSION, TRUE).'</pre>';

	$update_query = "UPDATE schedule SET quantity_area1 = quantity_area1-".$itemArray["quantity_area1"].", quantity_area2 = quantity_area2-".$itemArray["quantity_area2"].", 
	quantity_area3 = quantity_area3-".$itemArray["quantity_area3"].", quantity_area4= quantity_area4-".$itemArray["quantity_area4"]." WHERE showid=".$_POST["showid"]. " and scheduleid=".$_POST["scheduleid"].";";
	$update_result = $db->query($update_query);

	
	$retrieval_query = "SELECT * FROM schedule WHERE showid=".$_POST["showid"]. " and scheduleid=".$_POST["scheduleid"];
	$retrieval_result = $db->query($retrieval_query);
	$retrieved_row=mysqli_fetch_assoc($retrieval_result);
	echo '<pre>'; print_r($retrieved_row); echo '</pre>';
	
}
unset ($_POST["buy"]);

#$timezone = date_default_timezone_get();
#echo "The current server timezone is: " .$timezone;
?>
<html lang="en">
    <head>
        <title>The BlackSheep Theatre Company</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
		<style>
	
		</style>
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
				    <li><a class="active" href="plays.html">Plays</a>&nbsp;<li>
				    <li><a href="contact.html">Contact Us</a>&nbsp;</li>
                    <a style="float:right" href="cart.php">
                        <div class="cart-image">
                              <img src="images/cart-image.png">
                        </div>
                  </a>
                </ul>
            </nav>
			
			<div id="headingtext">
				<p>Available Showtimes</p>
			</div>
			<?php
			$date = date('Y-m-d H:i:s');
			$query = "SELECT * FROM schedule WHERE schedule.datetime >= '".$date."' and showid=2";
			$result = $db->query($query);
			$num_results = $result->num_rows;
			while($row=mysqli_fetch_assoc($result)) {
				$resultset[] = $row;
			}
			#echo '<pre>'; print_r($resultset); echo '</pre>';
			#var_dump($resultset[0]["datetime"]);
			
			?>
			<div id="content">
				<table>
				<?php for ($i=0; $i < $num_results; $i++) {
					$show_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $resultset[$i]["datetime"]);
					$show_date = $show_datetime->format('jS F Y');
					$show_time = $show_datetime->format('h:i a');
				?>
					<tr>
						<td><?php echo $show_date."<br>"; 
								echo $show_time."<br><br><br><br>"; 
						?></td>
						<td>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
							<input type="hidden" name="scheduleid" value="<?php echo $resultset[$i]["scheduleid"]; ?>">
							<input type="hidden" name="showid" value="<?php echo $resultset[$i]["showid"]; ?>">
							<input type="hidden" name="buy" value="<?php echo "1"; ?>">
							<br><br><label for="quantity_area1">S$60:</label>
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
							</select>
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
							</select>
							<label for="quantity_area3">S$35:</label>
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
							</select>
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
							</select>
							<td><input type="submit" value="Add to Cart" class="submitbutton"></input></td>
						</form>
						</td>
					</tr>
				<?php }
				?>
				</table>
				<a href="cart.php" class="submitbutton">View Cart</a>
			</div>
			<br><br>
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