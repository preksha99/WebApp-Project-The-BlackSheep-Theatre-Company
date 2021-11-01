<?php 
# Contact Submission and Confirmation Page
$to      = 'f32ee@localhost';
$subject_cust = 'Thank you for contacting The BlackSheep Theatre Company';
$subject_admin = 'Admin - New query recieved!';
$message_cust = "Dear ".$_POST['name'].",
Thank you for contacting The BlackSheep Theatre Company. 
We will get back to you in 1-2 days at '".$_POST['email']."'. 
We look forward to serving you soon.

Best Regards,
The BlackSheep Theatre Company";

$message_admin = "Hi Admin, a new query has been recieved.

Name: ".$_POST['name']."
Phone: ".$_POST['phone']."
Email: ".$_POST['email']."
Query: ".$_POST['queries']."

Kindly respond at the earliest!";

$headers = 'From: f32ee@localhost' . "\r\n" .
    'Reply-To: f32ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject_cust, $message_cust, $headers,'-ff32ee@localhost');
mail($to, $subject_admin, $message_admin, $headers,'-ff32ee@localhost');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The BlackSheep Theatre Company - Contact</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>
    <body>
	<script type = "text/javascript"  src = "js/contact_validation.js" ></script>
    <nav>
                <ul id="nav">
                    <a style="float:left" href="#">
                        <div class="logo-image">
                              <img src="images/logo-image.png" class="img-fluid">
                        </div>
                  </a>
                    <li><a href="index.html">Home</a>&nbsp;</li>
				    <li><a href="plays.html">Plays</a>&nbsp;<li>
				    <li><a class="active" href="contact.html">Contact Us</a>&nbsp;</li>
            
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
				<img src="images/thankyou.png" width=600px height=382px style="margin-left:auto;">
				<p style="font size: 30px;">We will reach out to you within 1-2 days.</p><br>

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