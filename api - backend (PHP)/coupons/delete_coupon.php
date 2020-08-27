<?php

require 'dbconnect.php';

$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($conn, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

$sql = "DELETE FROM `kuponi` WHERE `codeCoupon`='{$id}' LIMIT 1";

if(mysqli_query($conn, $sql))
{
  http_response_code(204);
}
else
{
  return http_response_code(422);
}

?>