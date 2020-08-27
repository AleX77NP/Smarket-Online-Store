<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    $novi = json_decode($postdata);
    $email = $novi->email;
    $ime =   $novi->name;
    $prezime = $novi->surname;
    $adresa = $novi->address;
    $telefon = $novi->phoneNum;
    
    if(!preg_match("/^([a-zA-Z ćčČĆ]{3,30}+)$/",$ime) || !preg_match("/^([a-zA-Z ćčČĆ]{3,30}+)$/",$prezime)||
    !preg_match("/^([a-zA-Z ćčČĆ0-9,]{20,150}+)$/",$adresa) || !preg_match("/^([0-9+ ]{6,15}+)$/",$telefon)) {
        http_response_code(400);
        echo "Uneti podaci nisu validni.";
    }
    else {
  
        $upit = "UPDATE `korisnici` SET `name` = '$ime', `surname`='$prezime', `address`='$adresa', `phoneNum`='$telefon'
        WHERE `email` = '{$email}' LIMIT 1";
        $rez = mysqli_query($conn, $upit);
        if($rez) {
            http_response_code(200);
             echo json_encode("Korisnik promenjen.");
        }
        else {
            echo json_encode("Izmena nije uspela.");
            http_response_code(400);
        }
    }

}
else {
    http_response_code(422);
}


?>