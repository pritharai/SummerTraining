<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/wamp64/www/SummerTraining/SummerTraining/ComposerSetup/vendor/autoload.php';

include("connect.php");

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    if (isset($_POST['action']) && $_POST['action'] === 'subscribe') {
        // Subscribe the user
        $stmt = $con->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
        if (!$stmt) {
            echo 'Prepare failed: (' . $con->errno . ') ' . $con->error;
            exit();
        }
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
            exit();
        }
        $stmt->close();

        // Send welcome email
        sendWelcomeEmail($email);

        echo 'subscribed';
    } elseif (isset($_POST['action']) && $_POST['action'] === 'unsubscribe') {
        // Unsubscribe the user
        $stmt = $con->prepare("DELETE FROM newsletter_subscribers WHERE email = ?");
        if (!$stmt) {
            echo 'Prepare failed: (' . $con->errno . ') ' . $con->error;
            exit();
        }
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
            exit();
        }
        $stmt->close();

        echo 'unsubscribed';
    } else {
        echo 'Invalid action.';
    }
} else {
    echo 'No email provided.';
}

function sendWelcomeEmail($email) {
    // Send emails using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'raiprithaweb@gmail.com'; // SMTP username
        $mail->Password = 'official_1001'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email to you
        $mail->setFrom('noreply@example.com', 'Newsletter');
        $mail->addAddress('raiprithaweb@gmail.com'); // Replace with your email

        $mail->isHTML(true);
        $mail->Subject = 'New Newsletter Subscription';
        $mail->Body    = "A new user has subscribed to the newsletter with the email: $email";
        $mail->send();

        // Thank-you email to the subscriber
        $mail->clearAddresses();
        $mail->addAddress($email);

        $mail->Subject = 'Thank You for Subscribing';
        $mail->Body    = 'Thank you for subscribing to our newsletter! You will receive a 20% discount on your next purchase.';
        $mail->send();

        // Clear any lingering addresses
        $mail->clearAddresses();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
