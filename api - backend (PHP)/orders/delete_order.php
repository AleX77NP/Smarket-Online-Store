<?php

require_once 'dbconnect.php';

$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($conn, (int)$_GET['id']) : false;

if(!$id)
{
  http_response_code(400);
}

$upit = "DELETE FROM kupovina WHERE idOrder ='$id' LIMIT 1";
$upit2 = "DELETE FROM sadrzi WHERE idOrder ='$id'";


if(mysqli_query($conn, $upit))
{
  if(mysqli_query($conn, $upit2)) {
  http_response_code(200);
  echo json_encode("Brisanje uspelo");
    }
    else {
        http_response_code(400);
  echo json_encode("Brisanje nije uspelo");
    }
}
else
{
  http_response_code(422);
  echo json_encode("Brisanje nije uspelo");

}

?>