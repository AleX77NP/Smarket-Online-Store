<?php 

    require_once 'dbconnect.php';

    $korisnik = file_get_contents("php://input");
    $novi = json_decode($korisnik);
    $email = $novi->email;
    $lozinka = $novi->password;
    $ime = $novi->name;
    $prezime = $novi->surname;
    $adresa = $novi->address;
    $telefon = $novi->phoneNum;
    $admin = $novi->admin;
  
    
    if(isset($korisnik) && !empty($korisnik)) {
        if(!preg_match("/^([a-zA-Z ćčČĆ]{3,30}+)$/",$ime) || !preg_match("/^([a-zA-Z ćčČĆ]{3,30}+)$/",$prezime) ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($lozinka) < '6'  || !preg_match("#[0-9]+#",$lozinka) || 
    !preg_match("/^([a-zA-Z ćčČĆ0-9,]{20,150}+)$/",$adresa) || !preg_match("/^([0-9+ ]{6,15}+)$/",$telefon) ||
    !preg_match("#[A-Z]+#",$lozinka) || !preg_match("#[a-z]+#",$lozinka)) {
        http_response_code(400);
        echo "Uneti podaci nisu validni.";
    } else {

    $lozinka = password_hash($lozinka, PASSWORD_DEFAULT);

    $upit = "INSERT INTO korisnici (email,password,name,surname,address,phoneNum,admin) VALUES 
    ('$email', '$lozinka', '$ime', '$prezime', '$adresa', '$telefon', '$admin')";

    if(mysqli_query($conn, $upit)) {
        http_response_code(201);
        
        $to = $email;
        $message = "Hvala Vam na poverenju ," .$email. ". Uživajte u korišćenju sajta. Tim SMarket";
        $message = wordwrap($message,70);
        $subject = "SMarket registracija";
        $headers = 'From: milanovicaleX77@gmail.com' . "\r\n" .
        'Reply-To: milanovicaleX77@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $mejl = mail($to, $subject, $message, $headers);

        $user = [
        'email' => $email,
        'password' => $lozinka,
        'name'    => $ime,
        'surname' => $prezime,
        'address' => $adresa,
        'phoneNum' => $telefon,
        'admin' => $admin
          ];
        echo json_encode($user);
    }
    else {
        http_response_code(404);
        echo "Email adresa koju ste uneli je zauzeta.";
   }
  }
}
else {
    http_response_code(422);
}

?>