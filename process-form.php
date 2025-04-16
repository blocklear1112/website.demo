<?php
// filepath: process-form.php (Place this file in the same directory as index.html on your server)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- Recipient Email ---
    $recipient_email = "sdservice@gmail.com"; // CHANGE THIS TO YOUR EMAIL

    // --- Get and Sanitize Form Data ---
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $phone = filter_var(trim($_POST["phone"]), FILTER_SANITIZE_STRING);
    $appliance = filter_var(trim($_POST["appliance"]), FILTER_SANITIZE_STRING);
    $description = filter_var(trim($_POST["description"]), FILTER_SANITIZE_STRING);

    // Basic validation (add more as needed)
    if (empty($name) || empty($phone) || empty($appliance)) {
        // Handle error - redirect back or show message
        echo "Please fill out all required fields.";
        exit;
    }

    // --- Compose Email ---
    $subject = "New Appointment Request from $name";
    $email_body = "You have received a new appointment request:\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Phone: $phone\n";
    $email_body .= "Appliance Type: $appliance\n";
    $email_body .= "Description:\n$description\n";

    // --- Set Headers ---
    // Use a "From" address that your hosting allows, often related to your domain
    $headers = "From: webmaster@" . $_SERVER['SERVER_NAME'] . "\r\n";
    $headers .= "Reply-To: $name <$recipient_email>"; // You might want Reply-To set to the sender's email if you collect it

    // --- Send Email ---
    if (mail($recipient_email, $subject, $email_body, $headers)) {
        // --- Success: Redirect to a Thank You page ---
        // Create a thank-you.html page
        header("Location: thank-you.html");
        exit;
    } else {
        // --- Error ---
        echo "There was a problem sending your request. Please try again later or call us.";
        // You might want to log the error here
    }

} else {
    // Not a POST request, redirect or show error
    echo "Invalid request method.";
    exit;
}
?>