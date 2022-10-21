<?php
// include required phpmailer files
require './includes/SMTP.php';
require './includes/PHPMailer.php';
require './includes/Exception.php';
// define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function writeGeo($lat, $lon) {
    if ($lat == 'undefined' || $lon == 'undefined') {
        return;
    }
    $json = '{
        "lat": "' . $lat . '",
        "lon": "' . $lon . '"
        }';
    $f = fopen('coords.json', 'w');
    fwrite($f, $json);
    fclose($f);
    echo "File written successfully";
}

function calcDistance($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'k') {
    $theta = $longitude1 - $longitude2;
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;
    switch ($unit) {
        case 'm':
            break;
        case 'k':
            $distance = $distance * 1.609344;
    }
    if (round($distance, 2) <= 0.2) {
        return true;
    }
    return false;
}

function sendMail($isClose) {
    // create instance of phpmailer
    $mail = new PHPMailer();
    // set mailer to use SMTP
    $mail->isSMTP();
    // define SMTP host
    $mail->Host = "smtp.gmail.com";
    // enable SMTP authentication
    $mail->SMTPAuth = "true";
    // set type of encryption (SSL / TLS)
    $mail->SMTPSecure = 'tls';
    // set port of connect SMTP
    $mail->Port = "587";
    // set gmail username
    $mail->Username = "karakebus.3000@gmail.com";
    // set gmail password
    $mail->Password = "qtkcouoodjiqpxmv";
    // set email subject
    if ($isClose) {
        $mail->Subject = 'it\'s here';
    } else {
        $mail->Subject = 'it\'s OUT of here';
    }
    // set email sender
    $mail->setFrom("karakebus.3000@gmail.com");
    // set email body
    $mail->Body = "this is plain text";
    // add recipient
    $mail->addAddress("karake.design@gmail.com");
    // finally send email
    if ($mail->send()) {
        echo 'coool' . '<br/>';
    } else {
        echo 'not cool' . '<br/>';
    }
    // close SMTP conncetion
    $mail->smtpClose();
}

function writeStatus($status) {
    $f = fopen('coords.json', 'w');
    if ($status) {
        fwrite($f, 'RUN');
    } else {
        fwrite($f, 'STOP');
    }
    fclose($f);    
}

function checkStatus() {
    $f = fopen('status.txt', 'r');
    $status = fread($f, filesize('status.txt'));
    if ($status == 'RUN') {
        return true;
    }
    return false;
}