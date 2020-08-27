<?php


if($_SERVER['REQUEST_METHOD']=='GET') {
 
 require_once 'dbconnect.php';
 
    $upit = "SELECT * FROM admini";
    $rezultat = mysqli_query($conn,$upit);
    if($rezultat) {
        while($r = mysqli_fetch_assoc($rezultat)) {
            $admini['lista'][] = $r;
          }
        echo json_encode($admini['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }
}
else {
    http_response_code(400);
}

?>