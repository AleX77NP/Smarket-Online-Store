<?php

require 'dbconnect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
 if(!preg_match("/^([a-zA-Z0-9, ćčČĆ]{10,50}+)$/",$request->address) || !preg_match("/^([0-9]{2,4}+)$/",$request->size)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  
  else {

  // Sanitize.
  $idMesta    = mysqli_real_escape_string($conn, (int)$request->idPlace);
  $adresa = mysqli_real_escape_string($conn, trim($request->address));
  $velicina = mysqli_real_escape_string($conn, (int)$request->size);

  $sql = "UPDATE `prodajna_mesta` SET `address`='$adresa',`size`='$velicina' WHERE `idPlace` = '{$idMesta}' LIMIT 1";

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