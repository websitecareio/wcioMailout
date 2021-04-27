# wcioMailout
##### Tired of setting up SMTP plugins on client sites all the time, or have to change the same information on several sites. Then you can use wcopMailout to make changes only one place. After you have setup the server part of the scripts, you can easily install the WordPress plugin or standalone version on your sites and have all e-mails run thru your e-mail service and only have to change SMTP details one place in the future.

## Features

- WordPress plugin with easy configuration of username / password
- Standalone code you can inplement on any site
- PHPMailer integration
- SendGrid integration
- Logging of all sent e-mail for debugging purposes
- Automatic log cleanup (Default 7 days)
- E-mail validation

## How to use WordPress plugin
Lorem ipsum dolor sit amet...

## How to use Srandalone version
The standalone version requires you to work a bit. Implementing it into your site where needed. 

Below you can see a simple way to use the standalone version.

```sh
<?php
require("client/standalone/code.php"); // wcioMailout function

// Send mail
// wcio_mail($to, $from, $subject, $message, $headers)

$headers = "Reply-To: replyto@mail.com";

wcio_mail(
    "to@mail.com",
    "from@mail.com",
    "Mail subject here",
    "Email content here including HTML",
    $headers);

?>
```

## Accepted headers
The headers part only accepts some type of headers. Here is the full allowed headers. When entering headers a new line is needed for the server part to split it up correctly.

```sh
From: from@mail.com
Cc: cc@mail.com
Bcc: bcc@mail.com
Reply-to: replyto@mail.com
```

## Requirements
- PHP 7.5+
- cURL
