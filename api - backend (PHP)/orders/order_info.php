<?php

require 'dbconnect.php';

$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($conn, (int)$_GET['id']) : false;
$email = $_GET['email'];

if(!$id || !$email)
{
  return http_response_code(400);
}


$upit = "SELECT kupovina.totalPrice as Ukupna_Cena, sadrzi.idOrder as ID, proizvodi.name as Naziv,proizvodi.price as cena, sadrzi.countP as Kolicina, sadrzi.price as Ukupno_artikal FROM sadrzi,proizvodi,kupovina WHERE proizvodi.id
= sadrzi.idProduct AND sadrzi.idOrder = kupovina.idOrder AND kupovina.idOrder = '$id'";

$upit2 = "SELECT address,phoneNum FROM korisnici WHERE email = '$email' LIMIT 1";
$rez2 = mysqli_query($conn, $upit2);

$user = mysqli_fetch_assoc($rez2);
$adresa = $user['address'];
$telefon = $user['phoneNum'];

$rez = mysqli_query($conn, $upit);

if($rez && $rez2) {
    while($r = mysqli_fetch_assoc($rez)) {
        $items['lista'][] = $r;
      }
      $niz = $items['lista'];
      $ukupno = 0;
     $poruka = "Naziv artikla   |   cena   |   količina   |   ukupno"."\r\n";
    foreach($niz as $vrednost) {
        $poruka.= $vrednost['Naziv']."  -  ".$vrednost['cena']." RSD"."  x  ".$vrednost['Kolicina']."\r\n"."Ukupno artikal: ".$vrednost['Ukupno_artikal']." RSD"."\r\n";
        $ukupno = $ukupno + $vrednost['Ukupno_artikal'];
    }
    $taksa = $ukupno*0.05;
    $sve = $ukupno + $taksa;
    $poruka.= "\r\n"."Ukupno korpa: ".$ukupno." RSD"."\r\n"."Poštarina: ".$taksa." RSD"."\r\n"."Ukupno za uplatu: ".$sve." RSD"."\r\n"."Adresa: ".$adresa."\r\n"."Telefon: ".$telefon."\r\n"."\r\n"."Hvala Vam na poverenju,"."\r\n"."Tim SMarket";
    
        $to = $email;
        $message = $poruka;
        $subject = "SMarket kupovina:"." Porudžbina: ".$id;
        $headers = 'From: milanovicaleX77@gmail.com' . "\r\n" .
        'Reply-To: milanovicaleX77@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
         $mejl = mail($to, $subject, $message, $headers);
    
    if($mejl)  {
        http_response_code(200);
        echo json_encode("Potvrda");
        mysqli_close($conn);
    }
    else
    http_response_code(400);
    mysqli_close($conn);
}
else {
    http_response_code(404);
}


?>