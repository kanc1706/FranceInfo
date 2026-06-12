<?php
session_start();
include 'connect.php';

$uspjesnaPrijava = false;
$admin = false;
$imeKorisnika = "";

if (isset($_POST['prijava'])) {
    $prijavaImeKorisnika = $_POST['username'];
    $prijavaLozinkaKorisnika = $_POST['lozinka'];

    $sql = "SELECT ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $dbIme, $dbLozinka, $dbRazina);
        mysqli_stmt_fetch($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($prijavaLozinkaKorisnika, $dbLozinka)) {
            $uspjesnaPrijava = true;
            $imeKorisnika = $dbIme;
            $admin = ($dbRazina == 1);
            $_SESSION['username'] = $imeKorisnika;
            $_SESSION['level'] = $dbRazina;
        }
    }
} else if (isset($_SESSION['username'])) {
    $uspjesnaPrijava = true;
    $imeKorisnika = $_SESSION['username'];
    $admin = ($_SESSION['level'] == 1);
}

if(isset($_POST['delete']) && $admin) {
    $id = $_POST['id'];
    $query = "DELETE FROM vijesti WHERE id=$id";
    mysqli_query($dbc, $query);
}

if(isset($_POST['update']) && $admin) {
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $picture = $_FILES['pphoto']['name'];
    $archive = isset($_POST['archive']) ? 1 : 0;
    $id = $_POST['id'];
    
    if($picture != "") {
        $target_dir = 'img/'.$picture;
        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
        $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content', slika='$picture', kategorija='$category', arhiva='$archive' WHERE id=$id";
    } else {
        $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content', kategorija='$category', arhiva='$archive' WHERE id=$id";
    }
    mysqli_query($dbc, $query);
}

if(isset($_POST['submit']) && $admin) {
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $picture = $_FILES['pphoto']['name'];
    $target_dir = 'img/'.$picture;
    move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
    $query = "INSERT INTO vijesti (naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES ('$title', '$about', '$content', '$picture', '$category', 0)";
    mysqli_query($dbc, $query);
}

if (isset($_GET['odjava'])) {
    session_destroy();
    header("Location: administracija.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>FranceInfo - Administracija</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #fdfdfd; color: #333; display: flex; flex-direction: column; min-height: 100vh; }
        header { max-width: 1200px; margin: 0 auto; padding: 20px; width: 100%; }
        .logo { font-size: 36px; font-weight: bold; }
        .logo span { color: #f5a623; }
        nav { border-top: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0; background: #fff; }
        nav ul { list-style-type: none; display: flex; justify-content: center; gap: 40px; padding: 15px; }
        nav ul li a { text-decoration: none; color: #000; font-weight: bold; text-transform: lowercase; font-size: 14px; }
        main { max-width: 800px; margin: 40px auto; padding: 20px; flex: 1; width: 100%; }
        h1 { margin-bottom: 30px; border-bottom: 2px solid #f5a623; padding-bottom: 10px; }
        .admin-form { background: #fff; padding: 20px; margin-bottom: 40px; border-radius: 8px; border: 1px solid #eaeaea; }
        .form-item { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="password"], textarea, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; color: #fff; font-weight: bold; }
        button[name="update"], button[name="submit"] { background-color: #4CAF50; }
        button[name="delete"] { background-color: #f44336; }
        button[name="prijava"] { background-color: #111; width: 100%; padding: 15px; }
        .poruka { padding: 20px; background: #eee; text-align: center; font-weight: bold; margin-bottom: 20px; border: 1px solid #ccc; }
        footer { background-color: #f8f9fa; text-align: right; padding: 40px 80px; margin-top: auto; font-size: 12px; color: #888; }
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
        <li><a href="tecaj.php">tečaj</a></li>
        <li><a href="administracija.php">administracija</a></li>
    </ul>
</nav>

<main>
    <h1>Administracija</h1>

    <?php
    if ($uspjesnaPrijava && $admin) {
        echo '<div class="poruka">Bok '.htmlspecialchars($imeKorisnika).'! <a href="administracija.php?odjava=1">Odjavi se</a></div>';
        echo '<h2>Unos vijesti</h2>';
        echo '<form enctype="multipart/form-data" action="" method="POST" class="admin-form">';
        echo '<div class="form-item"><label>Naslov:</label><input type="text" name="title" required></div>';
        echo '<div class="form-item"><label>Sadržaj:</label><textarea name="content" rows="6" required></textarea></div>';
        echo '<div class="form-item"><label>Slika:</label><input type="file" name="pphoto" required></div>';
        echo '<div class="form-item"><label>Kategorija:</label><select name="category"><option value="elections">Elections</option><option value="lesjt">Les JT</option></select></div>';
        echo '<button type="submit" name="submit">Spremi vijest</button></form>';

        echo '<h2>Uredi/Izbriši</h2>';
        $query = "SELECT * FROM vijesti ORDER BY id DESC";
        $result = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_array($result)) {
            echo '<form enctype="multipart/form-data" action="" method="POST" class="admin-form">';
            echo '<div class="form-item"><label>Naslov:</label><input type="text" name="title" value="'.htmlspecialchars($row['naslov']).'"></div>';
            echo '<div class="form-item"><label>Sadržaj:</label><textarea name="content" rows="6">'.htmlspecialchars($row['tekst']).'</textarea></div>';
            echo '<div class="form-item"><label>Kategorija:</label><select name="category"><option value="elections" '.($row['kategorija']=='elections'?'selected':'').'>Elections</option><option value="lesjt" '.($row['kategorija']=='lesjt'?'selected':'').'>Les JT</option></select></div>';
            echo '<div class="form-item"><label><input type="checkbox" name="archive" '.($row['arhiva']==1?'checked':'').'/> Arhiviraj</label></div>';
            echo '<input type="hidden" name="id" value="'.$row['id'].'">';
            echo '<button type="submit" name="update">Izmijeni</button> <button type="submit" name="delete" onclick="return confirm(\'Sigurni?\');">Izbriši</button>';
            echo '</form>';
        }
    } else if ($uspjesnaPrijava && !$admin) {
        echo '<div class="poruka">Bok '.htmlspecialchars($imeKorisnika).', nemate ovlasti. <a href="administracija.php?odjava=1">Odjavi se</a></div>';
    } else {
        echo '<div class="admin-form"><form action="" method="POST">';
        echo '<div class="form-item"><label>Korisničko ime:</label><input type="text" name="username" required></div>';
        echo '<div class="form-item"><label>Lozinka:</label><input type="password" name="lozinka" required></div>';
        echo '<button type="submit" name="prijava">Prijavi se</button></form>';
        echo '<p style="text-align:center; margin-top:15px;">Nemate račun? <a href="registracija.php">Registrirajte se</a></p></div>';
    }
    ?>
</main>

<footer>
    <p>france.tv</p>
</footer>
</body>
</html>