<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $ime = $request->name;
  $prezime = $request->surname;
  $adresa = $request->address;
  $telefon = $request->phone;
  $plata = $request->salary;
  $smena = $request->shift;
  $mesto = $request->idPlace;
  $kasa = $request->idCashbox;

  if(!preg_match("/^([0-9]{6,15}+)$/",$telefon) || !preg_match("/^([0-9]{3,3}+)$/",$plata) || 
  !preg_match("/^([a-zA-Z ćčČĆ]{3,30}+)$/",$ime) || !preg_match("/^([a-zA-Z ćčČĆ]{3,30}+)$/",$prezime)
  || !preg_match("/^([a-zA-Z ćčČĆ0-9,]{20,150}+)$/",$adresa)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "INSERT into za_kasom (idWorker, name, surname, address, phone, salary, shift, idPlace, idCashbox) VALUES 
  (NULL, '$ime', '$prezime', '$adresa', '$telefon', '$plata', '$smena', '$mesto', '$kasa')";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(201);
    $radnik = [
      'idWorker' => mysqli_insert_id($conn),
      'name' => $ime,
      'surname' => $prezime,
      'address' => $adresa,
      'phone' => $telefon,
      'yearsOfS' => $staz,
      'idPlace' => $mesto,
      'idCashbox' => $kasa
    ];
    echo json_encode($radnik);
  }
  else {
      http_response_code(404);
      echo "Unos novog radnika nije uspeo.";
  }

  }
}
else {
    http_response_code(404);
}

?>