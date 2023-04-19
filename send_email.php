<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL & ~E_DEPRECATED);

// use Swift_SmtpTransport;
// use Swift_Mailer;
// use Swift_Message;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

require_once 'vendor/autoload.php';

// Create a new PHPMailer object
$mail = new PHPMailer(true); // Passing "true" enables exceptions


// Gmail SMTP credentials
$username = 'youremail@gmail.com';
$password = 'app_password';
$host = 'smtp.gmail.com';
$port = 587;


// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$discordUsername = $_POST['discord'] ?? '';
$twitchUsername = $_POST['twitch-username'] ?? '';
$youtubeUsername = $_POST['youtube-username'] ?? '';
$otherPlatform = $_POST['other-platform'] ?? '';
$stream_Platforms = array();
if (!empty($_POST['stream_platforms'])) {
    $stream_platforms = explode(", ", $_POST['stream_platforms']);
    if (in_array("other", $stream_platforms) && isset($_POST['other-platform'])) {
        $other_platform = trim($_POST['other-platform']);
        if (!empty($other_platform)) {
            $stream_platforms[] = $other_platform;
        }
    }
}
$stream_platforms_str = implode(", ", $stream_platforms);


$social_media = array();
if (isset($_POST['social-media'])) {
    if (is_array($_POST['social-media'])) {
        $social_media = $_POST['social-media'];
    } else {
        $social_media = array($_POST['social-media']);
    }
    if (in_array("other", $social_media) && isset($_POST['other-social-media'])) {
        $other_social_media = trim($_POST['other-social-media']);
        if (!empty($other_social_media)) {
            $social_media[] = $other_social_media;
        }
    }
}
$social_media = implode(", ", $social_media);


// get social media usernames
$twitter_username = "";
if (isset($_POST['twitter-username'])) {
    $twitter_username = trim($_POST['twitter-username']);
}
$youtube_username = "";
if (isset($_POST['youtube-username2'])) {
    $youtube_username = trim($_POST['youtube-username2']);
}
$instagram_username = "";
if (isset($_POST['instagram-username'])) {
    $instagram_username = trim($_POST['instagram-username']);
}
$tiktok_username = "";
if (isset($_POST['tiktok-username'])) {
    $tiktok_username = trim($_POST['tiktok-username']);
}


$referenceArtComment = $_POST['reference-art-notes'] ?? '';
$questionsOrConcerns = $_POST['questions-or-concerns'] ?? '';
$termsAgreement = $_POST['terms-agreement'] ?? '';
$codeWord = $_POST['code-word'] ?? '';
$substituteExpression = $_POST['substitute-expression'] ?? '';
$substituteExpressionDetails = $_POST['substitute-expression-details'] ?? '';
$arkit = $_POST['arkit'] ?? '';
$vive = $_POST['vive'] ?? '';
$extraOutfit = $_POST['extra-outfit'] ?? '';
$extraOutfitDetails = $_POST['extra-outfit-details'] ?? '';
$extraHairstyle = $_POST['extra-hairstyle'] ?? '';
$extraHairstyleDetails = $_POST['extra-hairstyle-details'] ?? '';
$pet = $_POST['pet'] ?? '';
$petDetails = $_POST['pet-details'] ?? '';
$extraObject = $_POST['extra-object'] ?? '';
$extraObjectDetails = $_POST['extra-object-details'] ?? '';
$extraExpression = $_POST['extra-expression'] ?? '';
$extraExpressionDetails = $_POST['extra-expression-details'] ?? '';
$modelPrivacy = $_POST['model-privacy'] ?? '';
$acceptPrivateFee = $_POST['accept-private-fee'] ?? '';



// Create the message
$messageBody = "
Email: $email\n
Discord Username: $discordUsername\n
Twitch Username: $twitchUsername\n
YouTube Username: $youtubeUsername\n
Other Platform: $otherPlatform\n
Stream Platforms: $stream_platforms_str\n
Social Media Sites: $social_media\n
Twitter Username: $twitter_username\n
YouTube Username: $youtube_username\n
Instagram Username: $instagram_username\n
TikTok Username: $tiktok_username\n
Reference Art Comment: $referenceArtComment\n
Questions or Concerns: $questionsOrConcerns\n
Substitute Expression: $substituteExpression\n
Substitute Expression Details: $substituteExpressionDetails\n
ARKit/iPhone Face Tracking Blendshapes: $arkit\n
Vive Face Tracker Blendshapes: $vive\n
Extra Outfit: $extraOutfit\n
Extra Outfit Details: $extraOutfitDetails\n
Extra Hairstyle: $extraHairstyle\n
Extra Hairstyle Details: $extraHairstyleDetails\n
Pet: $pet\n
Pet Details: $petDetails\n
Extra Object or Accessory: $extraObject\n
Extra Object or Accessory Details: $extraObjectDetails\n
Extra Facial Expression: $extraExpression\n
Extra Facial Expression Details: $extraExpressionDetails\n
Model Privacy: $modelPrivacy\n
Accept Private Fee: $acceptPrivateFee\n
Terms Agreement: $termsAgreement\n
Code Word: $codeWord\n
";
$message = (new Swift_Message('Commission Form Submission from ' . $name . ' (' . $email . ')'))
    ->setFrom([$email => $name])
    ->setTo(['prisma.sinclair@gmail.com']);
    // ->setBody($messageBody);


if (isset($_FILES['reference-art'])) {
    $file_names = $_FILES['reference-art']['name'];
    $tmp_names = $_FILES['reference-art']['tmp_name'];
    $errors = $_FILES['reference-art']['error'];
    $sizes = $_FILES['reference-art']['size'];

    $file_count = is_array($file_names) ? count($file_names) : 0;
    for ($i = 0; $i < $file_count; $i++) {
        $file_name = $file_names[$i];
        $tmp_name = $tmp_names[$i];
        $error = $errors[$i];
        $size = $sizes[$i];

        if ($error === UPLOAD_ERR_OK) {
            $attachment = Swift_Attachment::fromPath($tmp_name)->setFilename($file_name);
            $message->attach($attachment);
        }
    }
}


$html = "
<html>
<head>
<style>
  body { text-align: center; }
  table {
    border-collapse: collapse;
    margin: 0 auto; /* Center the table horizontally */
  }
  th, td {
    border: 1px solid black;
    padding: 5px;
  }
  th { background-color: #f2f2f2; }
</style>
</head>
<body>
<table>
<tr><th>Email</th><td>$email</td></tr>
<tr><th>Discord Username</th><td>$discordUsername</td></tr>
<tr><th>Twitch Username</th><td>$twitchUsername</td></tr>
<tr><th>YouTube Username</th><td>$youtubeUsername</td></tr>
<tr><th>Other Platform</th><td>$otherPlatform</td></tr>
<tr><th>Stream Platforms</th><td>$stream_platforms_str</td></tr>
<tr><th>Social Media Sites</th><td>$social_media</td></tr>
<tr><th>Twitter Username</th><td>$twitter_username</td></tr>
<tr><th>YouTube Username</th><td>$youtube_username</td></tr>
<tr><th>Instagram Username</th><td>$instagram_username</td></tr>
<tr><th>TikTok Username</th><td>$tiktok_username</td></tr>
<tr><th>Reference Art Comment</th><td>$referenceArtComment</td></tr>
<tr><th>Questions or Concerns</th><td>$questionsOrConcerns</td></tr>
<tr><th>Substitute Expression</th><td>$substituteExpression</td></tr>
<tr><th>Substitute Expression Details</th><td>$substituteExpressionDetails</td></tr>
<tr><th>ARKit/iPhone Face Tracking Blendshapes</th><td>$arkit</td></tr>
<tr><th>Vive Face Tracker Blendshapes</th><td>$vive</td></tr>
<tr><th>Extra Outfit</th><td>$extraOutfit</td></tr>
<tr><th>Extra Outfit Details</th><td>$extraOutfitDetails</td></tr>
<tr><th>Extra Hairstyle</th><td>$extraHairstyle</td></tr>
<tr><th>Extra Hairstyle Details</th><td>$extraHairstyleDetails</td></tr>
<tr><th>Pet</th><td>$pet</td></tr>
<tr><th>Pet Details</th><td>$petDetails</td></tr>
<tr><th>Extra Object or Accessory</th><td>$extraObject</td></tr>
<tr><th>Extra Object or Accessory Details</th><td>$extraObjectDetails</td></tr>
<tr><th>Extra Facial Expression</th><td>$extraExpression</td></tr>
<tr><th>Extra Facial Expression Details</th><td>$extraExpressionDetails</td></tr>
<tr><th>Model Privacy</th><td>$modelPrivacy</td></tr>
<tr><th>Accept Private Fee</th><td>$acceptPrivateFee</td></tr>
<tr><th>Terms Agreement</th><td>$termsAgreement</td></tr>\
<tr><th>Code Word</th><td>$codeWord</td></tr>

</table>
</body>
</html>
";
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$pdf = $dompdf->output();


$pdfFilePath = sys_get_temp_dir() . '/commission_form_submission.pdf';
file_put_contents($pdfFilePath, $pdf);

// Attach the generated PDF to the email
$pdfAttachment = Swift_Attachment::fromPath($pdfFilePath)->setFilename('commission_form_submission.pdf');
$message->attach($pdfAttachment);

// Create the transport
$transport = (new Swift_SmtpTransport($host, $port))
    ->setUsername($username)
    ->setPassword($password)
    ->setEncryption('tls'); // Use TLS encryption for Gmail SMTP

// Create the mailer using the created transport
$mailer = new Swift_Mailer($transport);

// Send the message
$numSent = $mailer->send($message);

// Display success
// header('Location: html\thankyou.html');
