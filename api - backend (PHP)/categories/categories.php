<?php


if($_SERVER['REQUEST_METHOD']=='GET') {

    require_once 'dbconnect.php';
    $upit = "SELECT * FROM kategorije";
    $rez = mysqli_query($conn,$upit);
    $kategorije = [];
    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $kategorije['lista'][] = $r;
          }
        echo json_encode($kategorije['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}

?>