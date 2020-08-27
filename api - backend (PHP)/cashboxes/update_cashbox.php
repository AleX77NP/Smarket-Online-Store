<?php

require 'dbconnect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
 if(!preg_match("/^([a-zA-Z0-9, ćčČĆ]{2,20}+)$/",$request->brand)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  
  else {

  // Sanitize.
  $idKase  = mysqli_real_escape_string($conn, (int)$request->idCashbox);
  $marka = mysqli_real_escape_string($conn, trim($request->brand));
  $mesto = mysqli_real_escape_string($conn, (int)$request->idPlace);

  $sql = "UPDATE `kase` SET `brand`='$marka',`idPlace`='$mesto' WHERE `idCashbox` = '{$idKase}' LIMIT 1";

  if(mysqli_query($conn, $sql))
  {
    http_response_code(200);
  }
 }
}
  else
{
    return http_response_code(422);
} 


?>