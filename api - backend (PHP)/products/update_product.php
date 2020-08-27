<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $idP = $request->id;
  $naziv = $request->name;
  $opis = $request->description;
  $cena = $request->price;
  $dostupno = $request->available;
  $kat = $request->category;
  $slika = $request->imageURL;
  $snabdevac = $request->idSupplier;

  if(!preg_match("/^([a-zA-Z0-9. ćčČĆŽžŠš]{3,25}+)$/",$naziv) || !preg_match("/^([a-zA-Z0-9,.:+ ćčČĆŽžŠš%]{10,255}+)$/",$opis)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "UPDATE proizvodi SET `name`='$naziv', `description`='$opis', `price`='$cena', `available`='$dostupno', `category`='$kat',
  `imageURL`='$slika', `idSupplier`='$snabdevac' WHERE `id` = '{$idP}'";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(200);
  }
  else {
      http_response_code(404);
      echo "Izmena proizvoda nije uspela.";
   }
  }
}
else {
    http_response_code(404);
}

?>