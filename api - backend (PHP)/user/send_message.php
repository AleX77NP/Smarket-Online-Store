<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $imePrezime = $request->nameSurname;
  $mejl = $request->email;
  $predmet = $request->subjectUser;
  $poruka = $request->messageUser;

  $to = "milanovicaleX77@gmail.com";
  $message = $poruka."\n".$imePrezime;
  $subject = $predmet;
  $headers = 'From:' .$mejl. "\r\n" .
  'Reply-To: '.$mejl.  "\r\n" .
  'X-Mailer: PHP/' . phpversion();
  $mail = mail($to, $subject, $message, $headers);
  if($mail) {
      echo json_decode("Poruka poslata!");
  }
  else {
      http_response_code(400);
  }

}
else {
    http_response_code(404);
}

?>