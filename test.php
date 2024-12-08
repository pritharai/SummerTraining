
$to = 'recipient@example.com';
$subject = 'Test Email';
$message = 'This is a test email.';
$headers = 'From: your-email@example.com' . "\r\n" .
           'Reply-To: your-email@example.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

$mailSent = mail($to, $subject, $message, $headers);

if ($mailSent) {
    echo 'Email sent successfully using PHP mail() function.';
} else {
    echo 'Failed to send email using PHP mail() function.';
}
