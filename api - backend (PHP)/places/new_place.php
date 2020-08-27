<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $adresa = $request->address;
  $velicina = $request->size;

  if(!preg_match("/^([a-zA-Z0-9, ćčČĆ]{10,50}+)$/",$adresa) || !preg_match("/^([0-9]{2,4}+)$/",$velicina)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "INSERT INTO prodajna_mesta (idPlace,address,size) VALUES (NULL,'$adresa','$velicina')";

  if(mysqli_query($conn, $upit)) {
    http_response_code(201);
    $mesto = [
      'idPlace' => mysqli_insert_id($conn),
      'address' => $adresa,
      'size' => $velicina,
    ];
    echo json_encode($mesto);
  }
  else {
      http_response_code(400);
      echo "Unos novog mesta nije uspeo.";
  }

 }

}
else {
    http_response_code(404);
}

?>