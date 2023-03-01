<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;

require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/vendor/autoload.php");

// $recipients = array(
//   'dyomin.rus@new-bokino.ru' => 'Ruslan2570',
//   'dyomin.rus@yandex.ru' => 'ruslan999'
// );

// sendMail($recipients, "Новое сообщение", "Кря-кря");

function sendMail($recipients, $subject, $body)
{

  $HOST = 'ssl://smtp.jino.ru';
  $SENDER = 'buh@new-bokino.ru';
  $PASS = 'buhwork_59';
  $PORT = '465';
  $CHARSET = 'UTF-8';

  $mail = new PHPMailer;
  $mail->isSMTP();
  $mail->Host = $HOST;
  $mail->SMTPAuth = true;
  $mail->Port = $PORT;
  $mail->Username = $SENDER;
  $mail->Password = $PASS;
  $mail->SMTPSecure = 'ssl';
  $mail->SetFrom($SENDER, "Бухгалтерская компания", 0);

  foreach($recipients as $profile){
    $mail->addAddress($profile['email'], $profile['name']);
  }

  $mail->CharSet = $CHARSET;
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $body;

  if (!$mail->send()) {
    echo $mail->ErrorInfo;
  }
}