<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $marka = $request->brand;
  $mesto = $request->idPlace;

  if(!preg_match("/^([a-zA-Z0-9 ćčČĆ]{2,20}+)$/",$marka)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "INSERT into kase (idCashbox, brand, idPlace) VALUES (NULL, '$marka', '$mesto')";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(201);
    $kasa = [
      'idCashbox' => mysqli_insert_id($conn),
      'brand' => $marka,
      'idPlace' => $mesto,
    ];
    echo json_encode($kasa);
  }
  else {
      http_response_code(404);
      echo json_encode("Unos novog magacina nije uspeo.");
    }

  }

}
else {
    http_response_code(404);
}

?>