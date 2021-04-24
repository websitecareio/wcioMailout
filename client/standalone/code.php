<?php
/**
 * wcioMailout Function
 * Description: https://github.com/websitecareio/wcioMailout/
 */
function wcio_mail($to, $from, $subject, $message, $headers)
{

$url = 'https://xxxxxxxxxxxxxxx'; // Url where your server script is locaed
$user ='clientmailout'; // Username is given by Websoitecare.io
$pass ='clientmailpassword'; // Password given by websitecare.io

$params = array(
    'api_user'  => $user,
    'api_key'   => $pass,
    'to'        => json_encode($to),
    'subject'   => $subject,
    'html'      => '',
    'text'      => $message,
    'from'      => $from,
    'headers'   => $headers,
  );

    // Generate curl request
    $ch = curl_init($url);
    // Tell curl to use HTTP POST
    curl_setopt ($ch, CURLOPT_POST, true);
    // Tell curl that this is the body of the POST
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
    // Tell curl not to return headers, but do return the response
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // obtain response
    $response = curl_exec($ch);

    curl_close($ch);

}
?>
