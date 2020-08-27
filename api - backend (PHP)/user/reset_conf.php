<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    $request = json_decode($postdata);
    $email = $request->email;
    $lozinka = $request->password;
    $kod = $request->resetCode;

    $upit1 = "SELECT * FROM reset_lozinke WHERE `email`='$email' AND `resetCode` = '$kod'";
    $rez1 = mysqli_query($conn, $upit1);

     $rezNum = mysqli_num_rows($rez1);

    if($rezNum == 1) {
        $lozinka = password_hash($lozinka, PASSWORD_DEFAULT);
        
        $upit2 = "UPDATE korisnici SET `password`= '$lozinka' WHERE `email`= '{$email}'";
        $rez2 = mysqli_query($conn, $upit2);
        
        if($rez2) {
            http_response_code(200);
           // echo json_encode("Promenena lozinke uspela!");
        }
        else {
            http_response_code(404);
        }
    }
    
    else {
        http_response_code(400);
    }

}

else {
    http_response_code(422);
}



?>