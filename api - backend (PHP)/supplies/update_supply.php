<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $id = $request->idS;
  $mesto = $request->idPlace;
  $snabdevac = $request->idSupplier;
  $artikal = $request->product;
  $kolicina = $request->quantity;
  $datum  = $request->date;

  if(!preg_match("/^([a-zA-Z0-9 ]{3,25}+)$/",$artikal)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "UPDATE snabdeva SET `idPlace`='$mesto', `idSupplier`='$snabdevac', `product`='$artikal', `quantity`='$kolicina', `date`='$datum'
  WHERE `idS` = '{$id}'";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(200);
  }
  else {
      http_response_code(404);
      echo "Unos novog snabdevanja nije uspeo.";
  }

  }
}
else {
    http_response_code(404);
}

?>