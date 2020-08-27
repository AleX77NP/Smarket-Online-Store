<?php

require 'dbconnect.php';

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);
    $datum = $request->dateOrder;
    $ukupna = $request->totalPrice;
    $mejl = $request->email;
    $kupon = $request->couponCode;

    $upit = "INSERT INTO kupovina (idOrder, dateOrder, totalPrice, email, couponCode) VALUES 
    (NULL, '$datum', '$ukupna', '$mejl', '$kupon')";

    $rez = mysqli_query($conn,$upit);
    if($rez) {
        http_response_code(201);
        $kupovina = [
            'idOrder' => mysqli_insert_id($conn),
            'dateOrder' => $datum,
            'totalPrice' => $ukupna,
            'email' => $mejl,
            'couponCode' => $kupon
        ];
        echo json_encode($kupovina);

    }
    else {
        http_response_code(400);
    }

}

else {
    http_response_code(404);
}



?>