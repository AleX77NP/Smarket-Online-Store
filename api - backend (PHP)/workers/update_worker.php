<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $idW = $request->idWorker;
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

  $upit = "UPDATE za_kasom SET `name`='$ime', `surname`='$prezime', `address`='$adresa', `phone`='$telefon', `salary`='$plata', `shift`= '$smena', `idPlace`='$mesto', `idCashbox`='$kasa'
   WHERE `idWorker` = '{$idW}'";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(200);
  }
  else {
      http_response_code(404);
      echo "Izmena radnika nije uspela.";
  }

  }
}
else {
    http_response_code(404);
}
?>