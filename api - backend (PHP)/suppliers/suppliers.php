<?php


if($_SERVER['REQUEST_METHOD']=='GET') {

    require_once 'dbconnect.php';
    $upit = "SELECT * FROM snabdevaci";
    $rez = mysqli_query($conn,$upit);
    $snabdevaci = [];
    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $snabdevaci['lista'][] = $r;
          }
        echo json_encode($snabdevaci['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}

?>