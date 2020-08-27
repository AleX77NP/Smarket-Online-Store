<?php


if($_SERVER['REQUEST_METHOD']=='GET') {

    require_once 'dbconnect.php';
    $upit = "SELECT * FROM snabdeva";
    $rez = mysqli_query($conn,$upit);
    $zalihe = [];
    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $zalihe['lista'][] = $r;
          }
        echo json_encode($zalihe['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}

?>