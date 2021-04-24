<?php
/**
 * Plugin Name: Websitecare Mailout Serivce
 * Plugin URI:  https://websitecare.io
 * Description: Mail sending using Websiteca.io's mail service
 * Version:     1.0.0
 * Author:      Kim Vinberg
 * Author URI:  https://websitecare.io
 * Text Domain: wcio
 * License:     GPLv2
 */

/**
 * Plugin Name: Overwrites default WP mail function
 * Description:
 */
if (!function_exists('wp_mail'))
{
    function wp_mail($to, $subject, $message, $headers = '', $attachments = array())
    {
        wcio_mail($to, $subject, $message, $headers);
    }
}

/**
 * Plugin Name: The actual function the sendds the mail.
 * Description:
 */
function wcio_mail($to, $subject, $message, $headers)
{

$url = 'https://mailout.websitecare.io';
$user ='clientmailout'; // Username is given by Websoitecare.io
$pass ='clientmailpassword'; // Password given by websitecare.io

$params = array(
    'api_user'  => $user,
    'api_key'   => $pass,
    'to'        => json_encode($to),
    'subject'   => $subject,
    'html'      => '',
    'text'      => $message,
    'from'      => get_option( 'admin_email' ),
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
