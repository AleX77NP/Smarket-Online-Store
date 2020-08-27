<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);
    $kupovina = $request->idOrder;
    $proizvod = $request->idProduct;
    $kolicina = $request->countP;
    $cena = $request->price;

    $upit = "INSERT INTO sadrzi (idOrder, idProduct, countP, price) VALUES ('$kupovina', '$proizvod', '$kolicina', '$cena')";
    
    $rez = mysqli_query($conn,$upit);

    if($rez) {
        http_response_code(201);
        echo json_encode("Ok!");
    }
    else {
              http_response_code(400);
    }

}

else {
    http_response_code(404);
}



?>