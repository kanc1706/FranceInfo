<?php
include 'connect.php';

$msg = '';
$registriranKorisnik = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_POST['username'];
    $lozinka = $_POST['pass'];
    
    $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
    $razina = 0;

    $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) > 0){
            $msg = 'Korisničko ime već postoji!';
        } else {
            $sql = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt);
                $registriranKorisnik = true;
            }
        }
    }
    mysqli_close($dbc);
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>FranceInfo - Registracija</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #fdfdfd; color: #333333; display: flex; flex-direction: column; min-height: 100vh; }
        header { max-width: 1200px; margin: 0 auto; padding: 20px; width: 100%; text-align: left; }
        .logo { font-size: 36px; font-weight: bold; color: #000; }
        .logo span { color: #f5a623; }
        nav { border-top: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0; width: 100%; background-color: #ffffff; }
        nav ul { list-style-type: none; display: flex; justify-content: center; gap: 80px; padding: 15px 20px; flex-wrap: wrap; }
        nav ul li a { text-decoration: none; color: #000; font-weight: bold; text-transform: lowercase; font-size: 14px; transition: color 0.3s; }
        nav ul li a:hover { color: #f5a623; }
        
        main { max-width: 600px; margin: 40px auto; padding: 40px; background: #fff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); flex: 1; width: 90%; }
        h1 { margin-bottom: 30px; text-transform: uppercase; font-size: 24px; border-bottom: 2px solid #f5a623; padding-bottom: 10px; }
        
        .form-item { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 14px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; outline: none; transition: border 0.3s; }
        button { width: 100%; padding: 15px; background-color: #111; color: #fff; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s; margin-top: 10px; }
        button:hover { background-color: #f5a623; }
        
        .bojaPoruke { color: red; font-size: 13px; display: block; margin-bottom: 5px; font-weight: bold; }
        .uspjeh { background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; text-align: center; font-weight: bold; border: 1px solid #c3e6cb; }
        
        footer { background-color: #f8f9fa; text-align: right; padding: 40px 80px; margin-top: auto; font-size: 12px; color: #888; border-top: 1px solid #eaeaea; }
    </style>
</head>
<body>

<header>
    <div class="logo">franceinfo<span>:</span></div>
</header>

<nav>
    <ul>
        <li><a href="index.php">home</a></li>
        <li><a href="kategorija.php?id=elections">elections</a></li>
        <li><a href="kategorija.php?id=lesjt">les jt</a></li>
        <li><a href="tecaj.php">tecaj</a></li>
        <li><a href="administracija.php">administracija</a></li>
    </ul>
</nav>

<main>
    <h1>Registracija korisnika</h1>

    <?php if($registriranKorisnik == true) { ?>
        <div class="uspjeh">Korisnik je uspješno registriran!</div>
    <?php } else { ?>
        
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="form-item">
                <span id="porukaIme" class="bojaPoruke"></span>
                <label for="ime">Ime:</label>
                <input type="text" name="ime" id="ime">
            </div>
            
            <div class="form-item">
                <span id="porukaPrezime" class="bojaPoruke"></span>
                <label for="prezime">Prezime:</label>
                <input type="text" name="prezime" id="prezime">
            </div>
            
            <div class="form-item">
                <span id="porukaUsername" class="bojaPoruke"><?php echo $msg; ?></span>
                <label for="username">Korisničko ime:</label>
                <input type="text" name="username" id="username">
            </div>
            
            <div class="form-item">
                <span id="porukaPass" class="bojaPoruke"></span>
                <label for="pass">Lozinka:</label>
                <input type="password" name="pass" id="pass">
            </div>
            
            <div class="form-item">
                <span id="porukaPassRep" class="bojaPoruke"></span>
                <label for="passRep">Ponovite lozinku:</label>
                <input type="password" name="passRep" id="passRep">
            </div>
            
            <div class="form-item">
                <button type="submit" id="slanje">Registriraj se</button>
            </div>
        </form>

    <?php } ?>
</main>

<footer>
    <p>france.tv</p>
</footer>

<script type="text/javascript">
document.getElementById("slanje").onclick = function(event) {
    var slanjeForme = true;

    var poljeIme = document.getElementById("ime");
    var ime = document.getElementById("ime").value;
    if (ime.length == 0) {
        slanjeForme = false;
        poljeIme.style.border="1px dashed red";
        document.getElementById("porukaIme").innerHTML="Unesite ime!";
    } else {
        poljeIme.style.border="1px solid green";
        document.getElementById("porukaIme").innerHTML="";
    }

    var poljePrezime = document.getElementById("prezime");
    var prezime = document.getElementById("prezime").value;
    if (prezime.length == 0) {
        slanjeForme = false;
        poljePrezime.style.border="1px dashed red";
        document.getElementById("porukaPrezime").innerHTML="Unesite prezime!";
    } else {
        poljePrezime.style.border="1px solid green";
        document.getElementById("porukaPrezime").innerHTML="";
    }

    var poljeUsername = document.getElementById("username");
    var username = document.getElementById("username").value;
    if (username.length == 0) {
        slanjeForme = false;
        poljeUsername.style.border="1px dashed red";
        document.getElementById("porukaUsername").innerHTML="Unesite korisničko ime!";
    } else {
        poljeUsername.style.border="1px solid green";
        document.getElementById("porukaUsername").innerHTML="";
    }

    var poljePass = document.getElementById("pass");
    var pass = document.getElementById("pass").value;
    var poljePassRep = document.getElementById("passRep");
    var passRep = document.getElementById("passRep").value;
    
    if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
        slanjeForme = false;
        poljePass.style.border="1px dashed red";
        poljePassRep.style.border="1px dashed red";
        document.getElementById("porukaPass").innerHTML="Lozinke se ne podudaraju ili su prazne!";
        document.getElementById("porukaPassRep").innerHTML="Lozinke se ne podudaraju ili su prazne!";
    } else {
        poljePass.style.border="1px solid green";
        poljePassRep.style.border="1px solid green";
        document.getElementById("porukaPass").innerHTML="";
        document.getElementById("porukaPassRep").innerHTML="";
    }

    if (slanjeForme != true) {
        event.preventDefault();
    }
};
</script>

</body>
</html>