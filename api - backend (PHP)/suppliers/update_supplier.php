<?php

require 'dbconnect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  $ime = $request->name;
  $lokacija = $request->location;

  if(!preg_match("/^([a-zA-Z0-9, ćčČĆ]{3,30}+)$/",$ime) ||!preg_match("/^([a-zA-Z0-9, ćčČĆ]{10,50}+)$/",$lokacija) ) {
    http_response_code(400);
    echo json_encode("Uneti podaci nisu validni.");
  }
  
  else {

  // Sanitize.
  $idSnabdevaca = mysqli_real_escape_string($conn, (int)$request->idSupplier);
  $ime = mysqli_real_escape_string($conn, $request->name);
  $lokacija = mysqli_real_escape_string($conn, trim($request->location));

  $sql = "UPDATE `snabdevaci` SET `name`='$ime', `location`='$lokacija' WHERE `idSupplier` = '{$idSnabdevaca}' 
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