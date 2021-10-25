<?php 
$to      = 'f32ee@localhost';
$subject = 'Thank you for contacting The BlackSheep Theatre Company';
$message = "Dear ".$_POST['name'].",
Thank you for contacting The BlackSheep Theatre Company. 
We will get back to you in 1-2 days at '".$_POST['email']."'. 
We look forward to serving you soon.

Best Regards,
The BlackSheep Theatre Company";
$headers = 'From: f32ee@localhost' . "\r\n" .
    'Reply-To: f32ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers,'-ff32ee@localhost');
#echo ("mail sent to : ".$to);
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
                              <img src="images/logo-image.png">
                        </div>
                  </a>
                    <li><a href="home.html">Home</a>&nbsp;</li>
				    <li><a href="plays.html">Plays</a>&nbsp;<li>
				    <li><a class="active" href="contact.html">Contact Us</a>&nbsp;</li>
					<li><a href="login.php">My Bookings</a>&nbsp;</li>
                    <a style="float:right" href="cart.php">
                        <div class="cart-image">
                              <img src="images/cart-image.png">
                        </div>
                  </a>
                </ul>
            </nav>
			<div id="headingtext">
				<p style="font size: 30px;">Thank you for contacting us! We will reach out to you within 1-2 days.</p><br>
				<img src="images/thankyou.jpg" width=600px height=382px style="margin-left:auto;">
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