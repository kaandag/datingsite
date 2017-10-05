<?php

function died($error) {
    echo "We are very sorry, but there were error(s) found with the form you submitted. ";
    echo "These errors appear below.<br /><br />";
    echo "$error<br /><br />";
    echo "Please go back and fix these errors.<br /><br />";
    die();
}

function clean_string($string) {
   $bad = array("content-type","bcc:","to:","cc:","href");
   return str_replace($bad,"",$string);
}

if(isset($_POST['email'])) {

    $email_to = "info@succes.media";
    $email_subject = "Flirtgids Contact";

    // validation expected data exists
    if(!isset($_POST['first_name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $first_name = $_POST['first_name']; // required

    $email_from = $_POST['email']; // required

    $comments = $_POST['comments']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
    }

    if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
    }

    if(strlen($error_message) > 0) {
    died($error_message);
    }

    $email_message = "Form details below.\n\n";

    $email_message .= "First Name: ".clean_string($first_name)."\n";

    $email_message .= "Email: ".clean_string($email_from)."\n";

    $email_message .= "Comments: ".clean_string($comments)."\n";

    // create email headers
    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($email_to, $email_subject, $email_message, $headers);
?>
<?php
    header('Refresh:0; url=https://www.flirtgids.nl/', true, 0);
    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
    }
    phpAlert("Bedankt voor uw bericht!\\n\\n We zullen zo snel mogelijk contact proberen op te nemen!");
}
?>

 
