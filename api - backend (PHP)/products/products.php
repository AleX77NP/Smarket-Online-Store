<?php


if($_SERVER['REQUEST_METHOD']=='GET') {
 
 require_once 'dbconnect.php';
    
    $upit = "SELECT * FROM proizvodi";
    $rezultat = mysqli_query($conn,$upit);
    if($rezultat) {
        while($r = mysqli_fetch_assoc($rezultat)) {
            $proizvodi['lista'][] = $r;
          }
        echo json_encode($proizvodi['lista']);
        mysqli_close($conn);
    }
    else {
        http_response_code(404);
    }

}


?>