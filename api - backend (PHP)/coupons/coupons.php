<?php


if($_SERVER['REQUEST_METHOD']=='GET') {

    require_once 'dbconnect.php';
    $upit = "SELECT * FROM kuponi";
    $rez = mysqli_query($conn,$upit);
    $kuponi = [];
    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $kuponi['lista'][] = $r;
          }
        echo json_encode($kuponi['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}

?>