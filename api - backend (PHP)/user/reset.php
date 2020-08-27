<?php

require 'dbconnect.php';

$email = $_GET['email'];

$random = bin2hex(random_bytes(3));

if(!$email) {
    http_response_code(400);
}
else {

    $upit = "INSERT INTO reset_lozinke (email, resetCode) VALUES ('$email', '$random')";
    $rez = mysqli_query($conn, $upit);
    if($rez) {
$to = $email;
$message = "Zdravo " .$email. ". Vaš kod za resetovanje lozinke je: ". $random."\r\n"."\r\n"."Tim SMarket";
$subject = "SMarket reset lozinke";
$headers = 'From: milanovicaleX77@gmail.com' . "\r\n" .
'Reply-To: milanovicaleX77@gmail.com' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
$mejl = mail($to, $subject, $message, $headers);

if($mejl) {
    http_response_code(200);
}
else {
  http_response_code(400);
  }
}
    else {
        http_response_code(404);
    }

}

?>