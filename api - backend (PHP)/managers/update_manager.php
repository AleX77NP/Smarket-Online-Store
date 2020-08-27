<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $idM = $request->idManager;
  $ime = $request->name;
  $prezime = $request->surname;
  $adresa = $request->address;
  $telefon = $request->phone;
  $plata = $request->salary;
  $staz = $request->yearsOfS;
  $mesto = $request->idPlace;

  if(!preg_match("/^([0-9]{6,15}+)$/",$telefon) || !preg_match("/^([0-9]{3,3}+)$/",$plata) || 
  !preg_match("/^([a-zA-Z ćčČĆ]{3,30}+)$/",$ime) || !preg_match("/^([a-zA-Z ćčČĆ]{3,30}+)$/",$prezime)
  || !preg_match("/^([a-zA-Z ćčČĆ0-9,]{20,150}+)$/",$adresa) || !preg_match("/^([0-9]{1,2}+)$/",$staz)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "UPDATE poslovodje SET `name`='$ime', `surname`='$prezime', `address`='$adresa', `phone`='$telefon', `salary`='$plata', `yearsOfS`= '$staz', `idPlace`='$mesto' WHERE `idManager` = '{$idM}'";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(200);
  }
  else {
      http_response_code(404);
      echo "Izmena poslovodje nije uspela.";
  }

  }
}
else {
    http_response_code(404);
}
?>