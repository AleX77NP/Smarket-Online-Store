<?php


if($_SERVER['REQUEST_METHOD']=='GET') {

    require_once 'dbconnect.php';
    $upit = "SELECT * FROM prodajna_mesta";
    $rez = mysqli_query($conn,$upit);
    $pmesta = [];
    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $pmesta['lista'][] = $r;
          }
        echo json_encode($pmesta['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}

?>