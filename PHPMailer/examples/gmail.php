<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

// lance les classes de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// path du dossier PHPMailer % fichier d'envoi du mail
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\SMTP;

//require '../vendor/autoload.php';

function send_Mail($destinataire, $pseudoDest, $objet, $message){

//Create a new PHPMailer instance
    $mail = new PHPMailer;
    $mail->isSMTP();

//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_OFF;

//Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;


    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = 'isen.cloud@gmail.com';
    $mail->Password = 'Azerty!974';

    $mail->setFrom('isen.cloud@gmail.com', 'Validation email');

//Set an alternative reply-to address
    $mail->addReplyTo('isen.cloud@gmail.com', 'Validation email');

//Set who the message is to be sent to
    $mail->addAddress($destinataire, $pseudoDest);

//Objet du mail
    $mail->Subject = $objet;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
    $mail->msgHTML($message, __DIR__);

//Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';

//Attach an image file
    if (isset($pathImage1))
    {
        $mail->addAttachment($pathImage1);
    }
    if (isset($pathImage2))
    {
        $mail->addAttachment($pathImage2);
    }


//send the message, check for errors
    if (!$mail->send()) {
        return 'Mailer Error: '. $mail->ErrorInfo;
    } else {
        return 'sent';
        //Section 2: IMAP
        //Uncomment these to save your message in the 'Sent Mail' folder.
        #if (save_mail($mail)) {
        #    echo "Message saved!";
        #}
    }
}

//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}

?>