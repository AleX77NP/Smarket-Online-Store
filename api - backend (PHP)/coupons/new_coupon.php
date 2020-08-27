<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  $request = json_decode($postdata);

  $kod = $request->codeCoupon;
  $datum = $request->expires;
  $validan = $request->valid;
  $popust = $request->discount;

  if(!preg_match("/^([0-9]{1,20}+)$/",$datum) || !preg_match("/^([0-9]{3,10}+)$/",$kod)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  else {

  $upit = "INSERT into kuponi (codeCoupon, cond, valid, discount) VALUES ('$kod', '$datum', '$validan', '$popust')";
  $rez  = mysqli_query($conn, $upit);

  if($rez) {
    http_response_code(201);
    $kupon = [
      'codeCoupon' => $kod,
      'expires' => $datum,
      'valid' => $validan,
      'discount' => $popust
    ];
    echo json_encode($kupon);
  }
  else {
      http_response_code(404);
      echo "Unos novog kupona nije uspeo.";
  }

  }
}
else {
    http_response_code(404);
}
 ?>