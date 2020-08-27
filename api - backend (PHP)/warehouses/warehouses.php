<?php


if($_SERVER['REQUEST_METHOD']=='GET') {

    require_once 'dbconnect.php';
    $upit = "SELECT * FROM magacini";
    $rez = mysqli_query($conn,$upit);
    $magacini = [];
    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $magacini['lista'][] = $r;
          }
        echo json_encode($magacini['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}

?>