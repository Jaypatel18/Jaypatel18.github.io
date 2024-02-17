<?php

include "./DbConnect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$lookup_result = mysqli_query($conn, "SELECT name FROM RSVP WHERE phone_number = '".mysqli_real_escape_string($conn, $_POST['phone_number'])."'");
	
	$query = '';
	if (mysqli_num_rows($lookup_result) !== 0) {
		$query = "UPDATE RSVP SET 
			name='".mysqli_real_escape_string($conn, $_POST['name'])."',
			email='".mysqli_real_escape_string($conn, $_POST['email'])."',
			pithi_guests=".mysqli_real_escape_string($conn, $_POST['pithi_guests']).",
			ganesh_sthapana_guests=".mysqli_real_escape_string($conn, $_POST['ganesh_sthapana_guests']).",
			garba_guests=".mysqli_real_escape_string($conn, $_POST['garba_guests']).",
			wedding_guests=".mysqli_real_escape_string($conn, $_POST['wedding_guests']).",
			reception_guests=".mysqli_real_escape_string($conn, $_POST['reception_guests']).",
			message='".mysqli_real_escape_string($conn, $_POST['message'])."'
			WHERE phone_number = '".mysqli_real_escape_string($conn, $_POST['phone_number'])."'";
	} else {
		$query = "INSERT INTO RSVP SET 
			name='".mysqli_real_escape_string($conn, $_POST['name'])."',
			email='".mysqli_real_escape_string($conn, $_POST['email'])."',
			phone_number='".mysqli_real_escape_string($conn, $_POST['phone_number'])."',
			pithi_guests=".mysqli_real_escape_string($conn, $_POST['pithi_guests']).",
			ganesh_sthapana_guests=".mysqli_real_escape_string($conn, $_POST['ganesh_sthapana_guests']).",
			garba_guests=".mysqli_real_escape_string($conn, $_POST['garba_guests']).",
			wedding_guests=".mysqli_real_escape_string($conn, $_POST['wedding_guests']).",
			reception_guests=".mysqli_real_escape_string($conn, $_POST['reception_guests']).",
			message='".mysqli_real_escape_string($conn, $_POST['message'])."'";
	}
	mysqli_query($conn, $query);

	sendConfirmationEmail($_POST['email'], $_POST['name'], $_POST['pithi_guests'], $_POST['ganesh_sthapana_guests'],
		$_POST['garba_guests'], $_POST['wedding_guests'], $_POST['reception_guests']);

	echo "OK";
}

function sendConfirmationEmail($to_email, $name, $pithi_guests, $ganesh_sthapana_guests, $garba_guests, $wedding_guests, $reception_guests) {
	try {
		$phpMailer = new PHPMailer(true);
		$phpMailer->isSMTP();
		$phpMailer->Host = "smtp.titan.email";
		$phpMailer->SMTPAuth = true;
		$phpMailer->Username = "questions@letsjam2024.com";
		$phpMailer->Password = "Jaypatel18961!";
		$phpMailer->SMTPSecure = "tls"; // or PHPMailer::ENCRYPTION_STARTTLS
		$phpMailer->Port = 587;
		$phpMailer->isHTML(true);
		$phpMailer->CharSet = "UTF-8";
		$phpMailer->setFrom("questions@letsjam2024.com", "Ami & Jay");

		$phpMailer->addAddress($to_email);
		$phpMailer->Subject = "Thanks for responding to Ami & Jay's Wedding Invitation";

		$body = "
			<p>Thank You for the response, $name!</p>
			<p>Keep this email for reference. It will let you update your response on Ami & Jay's <a href='https://letsjam2024.com'>website.</a></p>";

		if ($pithi_guests > 0 || $ganesh_sthapana_guests >0 || $garba_guests > 0 || $wedding_guests > 0 || $reception_guests > 0) {
			$body .= "<p>Below are the number of guests you RSVP'd for:</p>
						<ul>";

			if ($reception_guests > 0) {
				$body .= "<li>Welcome Party guests: $reception_guests<br>";
				$body .= "Date: July 13th, 2024<br>";
				$body .= "Time: 6:00PM onwards<br>";
				$body .= "Dinner: 6:00PM onwards<br>";
				$body .= "Address: 1002 US-9, Woodbridge Township, NJ 07095<br><br>";
				$body .= "Attire: Indian formal recommended but not required</li><br>";
			}

			if ($garba_guests > 0) {
				$body .= "<li>Mehndi guests: $garba_guests<br>";
				$body .= "Date: July 13th, 2024<br>";
				$body .= "Time: 6:00PM onwards<br>";
				$body .= "Dinner: 6:00PM onwards<br>";
				$body .= "Address: 1002 US-9, Woodbridge Township, NJ 07095<br><br>";
				$body .= "Attire: Indian formal recommended but not required</li><br>";
			}
			if ($pithi_guests > 0) {
				$body .= "<li>Ganesh Sthapana/Pithi guests: $pithi_guests<br>"; 
				$body .= "Date: July 14th, 2024<br>";
				$body .= "Time: 7:30 AM onwards<br>";
				$body .= "Breakfast: 7:30AM onwards<br>";
				$body .= "Pithi: 10:00AM onwards<br>";
				$body .= "Lunch: 11:00PM onwards<br>";
				$body .= "Address: 1002 US-9, Woodbridge Township, NJ 07095<br><br>";
				$body .= "Attire: Yellow Indian formal recommended but not required</li><br>";
			}
			if ($ganesh_sthapana_guests > 0) {
				$body .= "<li>Ganesh Sthapana/Pithi guests: $ganesh_sthapana_guests<br>";
				$body .= "Date: July 14th, 2024<br>";
				$body .= "Time: 7:30 AM onwards<br>";
				$body .= "Breakfast: 7:30AM onwards<br>";
				$body .= "Pithi: 10:00AM onwards<br>";
				$body .= "Lunch: 11:00PM onwards<br>";
				$body .= "Address: 1002 US-9, Woodbridge Township, NJ 07095<br><br>";
				$body .= "Attire: Yellow Indian formal recommended but not required</li><br>";
			}
			if ($wedding_guests > 0) {
				$body .= "<li>Wedding/Reception guests: $wedding_guests<br>";
				$body .= "Date: July 14th, 2024<br>";
				$body .= "Time: 4:00 PM onwards<br>";
				$body .= "Baarat: July 14th  2024, 4:00PM - 4:30PM<br>";
				$body .= "Cocktail hour: 4:30PM - 5:30PM<br>";
				$body .= "Wedding Ceremony: 5:30PM onwards<br>";
				$body .= "Dinner: 7:00PM - 8:30PM<br><br>";
				$body .= "Reception: 8:30PM onwards<br>";
				$body .= "Address: 1002 US-9, Woodbridge Township, NJ 07095<br><br>";
				$body .= "Attire: Indian formal for wedding and suit for reception (Optional)<br>";

				// $body .= '<span style="font-weight: bold !important">PS: Ceremony followed by a dinner break, then reception.</span></li><br>';

			}

			$body .= '<br><br>If you plan to stay at a hotel next to the events hall, click <a href="https://www.marriott.com/event-reservations/reservation-link.mi?id=1693234579321&key=GRP&app=resvlink" target="_blank">HERE</a> for a discounted hotel link.<br><br>';

			$body .= "We can't wait to celebrate our special day with you!";

			
			$body .= "</ul>";
		} else {
			$body .= "<p>We are sorry that you cannot make it to any of the events.</p>";
		}

		$body .= "<br/>
				  <p>Thank you,</p>
				  <p>Ami & Jay</p>";

		// $body .= "Our Wedding Registry: <a href='https://www.amazon.com/wedding/share/letsJAm2024'>Click here.</a></p>";

		$phpMailer->Body = $body;
		$phpMailer->IsHTML(true);
		$phpMailer->send();
	} catch (phpmailerException $e) {
  		echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  	echo $e->getMessage(); //Boring error messages from anything else!
	}
}