<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $naziv = $request->name;
  $prevod = $request->translated;

  if(!preg_match("/^([a-zA-Z .ćčČĆŽžŠš]{3,25}+)$/",$naziv) || !preg_match("/^([a-zA-Z ]{3,25}+)$/",$prevod)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "INSERT INTO kategorije (name, translated) VALUES ('$naziv', '$prevod')";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(201);
    $kategorija = [
      'name' => $naziv,
      'translated' => $prevod
    ];
    echo json_encode($kategorija);
  }
  else {
      http_response_code(404);
      echo "Unos nove kategorije nije uspeo.";
  }

  }
}
else {
    http_response_code(404);
}

?>