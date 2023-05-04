<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $name = strip_tags(trim($_POST["name"]));
  $dob = strip_tags(trim($_POST["dob"]));
  $security_license = strip_tags(trim($_POST["security_license"]));
  $security_license_number = strip_tags(trim($_POST["security_license_number"]));
  $security_license_level = strip_tags(trim($_POST["security_license_level"]));
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $telephone = strip_tags(trim($_POST["telephone"]));
  $any_other_information = strip_tags(trim($_POST["any_other_information"]));

  // Check for empty fields
  if (empty($name) || empty($dob) || empty($security_license) ||  empty($email) || empty($telephone) || empty($any_other_information)) {
    http_response_code(400);
    echo "Please fill out all fields.";
    exit;
  }

  // Validate email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please enter a valid email address.";
    exit;
  }

  // Set recipient email address
  $recipient = "securityoperations@c4-protection.com'";

  // Set email subject
  $subject = "New work with us application from $name";

  // Build the email content
  $email_content = "Name: $name\n";
  $email_content .= "Date of Birth: $dob\n";
  $email_content .= "Security License: $security_license\n";
  $email_content .= "Security License Number: $security_license_number\n";
  $email_content .= "Security License Level: $security_license_level\n";
  $email_content .= "Email: $email\n";
  $email_content .= "Telephone: $telephone\n";
  $email_content .= "Any Other Information:\n$any_other_information\n";

  // Build the email headers
  $headers = "From: $name <$email>\r\n";
  $headers .= "Reply-To: $email\r\n";

  // Send the email
  if (mail($recipient, $subject, $email_content, $headers)) {
    http_response_code(200);
    echo "Thank You! Your message has been sent.";
  } else {
    http_response_code(500);
    echo "Oops! Something went wrong and we couldn't send your message.";
  }
} else {
  // Not a POST request, set a 403 (forbidden) response code.
  http_response_code(403);
  echo "There was a problem with your submission, please try again.";
}
?>
