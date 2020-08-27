<?php


if($_SERVER['REQUEST_METHOD']=='GET') {

    require_once 'dbconnect.php';
    $upit = "SELECT * FROM kase";
    $rez = mysqli_query($conn,$upit);
    $kase = [];
    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $kase['lista'][] = $r;
          }
        echo json_encode($kase['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}

?>