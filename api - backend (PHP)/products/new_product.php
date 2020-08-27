<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $naziv = $request->name;
  $opis = $request->description;
  $cena = $request->price;
  $dostupno = $request->available;
  $kat = $request->category;
  $slika = $request->imageURL;
  $snabdevac = $request->idSupplier;

  if(!preg_match("/^([a-zA-Z0-9 .,ćčČĆŽžŠš]{3,25}+)$/",$naziv) || !preg_match("/^([a-zA-Z0-9,.: ćčČĆŽžŠš%]{10,295}+)$/",$opis)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "INSERT INTO proizvodi (name,description,price,available,category,imageURL,idSupplier) VALUES
  ('$naziv', '$opis', '$cena', '$dostupno', '$kat', '$slika', '$snabdevac')";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(201);
    $proizvod = [
      'id' => mysqli_insert_id($conn),
      'name' => $naziv,
      'description' => $opis,
      'price' => $cena,
      'available' => $dostupno,
      'category' => $kat,
      'imageURL' => $slika,
      'idSupplier' => $snabdevac
    ];
    echo json_encode($proizvod);
  }
  else {
      http_response_code(404);
      echo "Unos novog proizvoda nije uspeo.";
  }

  }
}
else {
    http_response_code(404);
}

?>