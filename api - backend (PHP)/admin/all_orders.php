<?php

require 'dbconnect.php';


    $upit = "SELECT kupovina.dateOrder,kupovina.email, sadrzi.idOrder, proizvodi.name, sadrzi.countP, sadrzi.price as totalProduct, 
    proizvodi.price, kupovina.totalPrice, kupovina.couponCode
    FROM kupovina, sadrzi, proizvodi WHERE kupovina.idOrder = sadrzi.idOrder AND proizvodi.id = sadrzi.idProduct";

    $rez = mysqli_query($conn, $upit);

    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $kupovine['lista'][] = $r;
          }
        echo json_encode($kupovine['lista']);
        mysqli_close($conn);

    }
    else {
        http_response_code(404);
    }



?>