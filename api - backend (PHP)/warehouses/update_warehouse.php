<?php

require 'dbconnect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
 if(!preg_match("/^([a-zA-Z0-9, ćčČĆ]{10,50}+)$/",$request->location) || !preg_match("/^([0-9]{2,4}+)$/",$request->size)) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  
  else {

  // Sanitize.
  $idMagacina = mysqli_real_escape_string($conn, (int)$request->idWarehouse);
  $lokacija = mysqli_real_escape_string($conn, trim($request->location));
  $velicina = mysqli_real_escape_string($conn, (int)$request->size);
  $idMesta = mysqli_real_escape_string($conn, (int)$request->idPlace);

  $sql = "UPDATE `magacini` SET `location`='$lokacija',`size`='$velicina',`idPlace`='$idMesta' WHERE `idWarehouse` = '{$idMagacina}' 
  LIMIT 1";

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