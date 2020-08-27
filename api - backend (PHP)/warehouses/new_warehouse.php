<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $lokacija = $request->location;
  $velicina = $request->size;
  $mesto = $request->idPlace;

  if(!preg_match("/^([a-zA-Z0-9, ćčČĆ]{10,50}+)$/",$lokacija) || !preg_match("/^([0-9]{2,4}+)$/",$velicina)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "INSERT into magacini (idWarehouse, location, size, idPlace) VALUES (NULL, '$lokacija', '$velicina', '$mesto')";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(201);
    $magacin = [
      'idWarehouse' => mysqli_insert_id($conn),
      'location' => $lokacija,
      'size' => $velicina,
      'idPlace' => $mesto
    ];
    echo json_encode($magacin);
  }
  else {
      http_response_code(404);
      echo "Unos novog magacina nije uspeo.";
  }

  }

}
else {
    http_response_code(404);
}

?>