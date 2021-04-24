<?php
function validate_email($email) {

  // Test for the minimum length the email can be
  if ( strlen( $email ) < 6 ) {
    return "0";
  }

  // Test for an @ character after the first position
 if ( strpos( $email, '@', 1 ) === false ) {
   return "0";
 }


   // Split out the local and domain parts
   list( $local, $domain ) = explode( '@', $email, 2 );

   // LOCAL PART
   // Test for invalid characters
   $local = preg_replace( '/[^a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]/', '', $local );
   if ( '' === $local ) {
     return "0";
   }

   // DOMAIN PART
   // Test for sequences of periods
   $domain = preg_replace( '/\.{2,}/', '', $domain );
   if ( '' === $domain ) {
     return "0";
   }

   // Test for leading and trailing periods and whitespace
   $domain = trim( $domain, " \t\n\r\0\x0B." );
   if ( '' === $domain ) {
   return "0";
   }

   // Split the domain into subs
   $subs = explode( '.', $domain );

   // Assume the domain will have at least two subs
   if ( 2 > count( $subs ) ) {
   return "0";
   }

   // Create an array that will contain valid subs
   $new_subs = array();

   // Loop through each sub
   foreach ( $subs as $sub ) {
     // Test for leading and trailing hyphens
     $sub = trim( $sub, " \t\n\r\0\x0B-" );

     // Test for invalid characters
     $sub = preg_replace( '/[^a-z0-9-]+/i', '', $sub );

     // If there's anything left, add it to the valid subs
     if ( '' !== $sub ) {
       $new_subs[] = $sub;
     }
   }

   // If there aren't 2 or more valid subs
   if ( 2 > count( $new_subs ) ) {
   return "0";
   }

   // Join valid subs into the new domain
   $domain = join( '.', $new_subs );

   // Put the email back together
   $sanitized_email = $local . '@' . $domain;

   // Congratulations your email made it!
   return "1";


}


      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\SMTP;
      use PHPMailer\PHPMailer\Exception;

$api_user = $_POST["api_user"];
$api_key = $_POST["api_key"];
$to = json_decode($_POST["to"]);

if( validate_email($to[0]) == "1") {

      $to = $to[0];

      } elseif( validate_email($to) == "1") {

            $to = $to;

                  } elseif( validate_email($to) == "1") {

                        return "Email adress to field is invalid $to";
                        exit;

                  }

$subject = $_POST["subject"];
$html = $_POST["html"];
$text = $_POST["text"];
$from = $_POST["from"];
$headers = $_POST["headers"];

$headers = explode("\n", $headers);
// Allowed users
$allowedUsers = array(
      "clientmailout" => array(
            "password" => "clientmailpassword",
      ),
);

if($allowedUsers[$api_user]["password"] == $api_key) {
      //Send email
      // Here we can use any mail service we want to.


      require './PHPMailer-master/src/Exception.php';
      require './PHPMailer-master/src/PHPMailer.php';
      require './PHPMailer-master/src/SMTP.php';


//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'xxxxxxxxxxxxxx';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'xxxxxxxxxxxx';                     //SMTP username
    $mail->Password   = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($from);
    $mail->addAddress($to);     //Add a recipient
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com'); // BCC NOT SUPPORTED

    // headers
    foreach($headers AS $header) {
          $tag = explode(": ", $header);

          if(strtolower($tag[0]) == "from") {

                $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
                preg_match_all($pattern, $tag[1], $matches);

                $mail->addReplyTo($matches[0][0]);

          }

          if(strtolower($tag[0]) == "cc") {
                $mail->addCC($tag[1]);
          }

          if(strtolower($tag[0]) == "bcc") {
                $mail->addBCC($tag[1]);
          }

          if(strtolower($tag[0]) == "reply-to") {
                $mail->addReplyTo($tag[1]);
          }
   }

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $text;
    $mail->AltBody = strip_tags($text);

    $mail->SMTPDebug = 0;
    $mail->CharSet = 'UTF-8';
    $mail->send();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

} else {
    echo "Unknown username or password.";
}
 ?>
