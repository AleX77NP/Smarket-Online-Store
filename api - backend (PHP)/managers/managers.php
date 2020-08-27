<?php


if($_SERVER['REQUEST_METHOD']=='GET') {

    require_once 'dbconnect.php';
    $upit = "SELECT * FROM poslovodje";
    $rez = mysqli_query($conn,$upit);
    $poslovodje = [];
    if($rez) {
        while($r = mysqli_fetch_assoc($rez)) {
            $poslovodje['lista'][] = $r;
          }
        echo json_encode($poslovodje['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}

?>