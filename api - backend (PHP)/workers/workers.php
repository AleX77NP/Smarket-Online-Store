<?php


if($_SERVER['REQUEST_METHOD']=='GET') {

    require_once 'dbconnect.php';
    $upit = "SELECT * FROM za_kasom";
    $rez = mysqli_query($conn,$upit);
    $radnici = [];
    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $radnici['lista'][] = $r;
          }
        echo json_encode($radnici['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}

?>