<?php
include 'connect.php';

if (isset($_POST['submit'])) {
    
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    
    if(isset($_POST['archive'])){
        $archive = 1;
    } else {
        $archive = 0;
    }

    $picture = $_FILES['pphoto']['name'];
    $target_dir = 'img/';
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
    move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file);

    $datum = date('Y-m-d');
    
    $query = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?, ?)";
              
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssssssi', $datum, $title, $about, $content, $picture, $category, $archive);
        
        if (!mysqli_stmt_execute($stmt)) {
            die("<div style='background: #ffe6e6; color: red; padding: 20px; text-align: center; font-size: 20px; font-weight: bold;'>MySQL greška pri unosu: " . mysqli_stmt_error($stmt) . "</div>");
        }
    } else {
        die("<div style='background: #ffe6e6; color: red; padding: 20px; text-align: center; font-size: 20px; font-weight: bold;'>MySQL greška u upitu: " . mysqli_error($dbc) . "</div>");
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Uspješan unos - FranceInfo</title>
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
        main { max-width: 900px; margin: 40px auto; padding: 40px; background: #fff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); flex: 1; width: 90%; }
        .tag-kategorija { color: #f5a623; text-transform: uppercase; font-weight: bold; font-size: 14px; margin-bottom: 15px; display: block; }
        h1 { font-size: 32px; margin-bottom: 20px; color: #111; line-height: 1.3; }
        .sazetak { font-size: 18px; font-style: italic; color: #555; margin-bottom: 30px; font-weight: bold;}
        .slika-clanka { width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px; margin-bottom: 30px; }
        .tekst-clanka { font-size: 16px; line-height: 1.8; color: #333; }
        .uspjeh-poruka { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 30px; text-align: center; border: 1px solid #c3e6cb; font-weight: bold; }
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
        <li><a href="elections.html">elections</a></li>
        <li><a href="lesjt.html">les jt</a></li>
        <li><a href="vrijeme.php">vrijeme</a></li>
        <li><a href="unos.php">administracija</a></li>
    </ul>
</nav>

<main>
    <div class="uspjeh-poruka">
        Vijest je uspješno dodana u bazu podataka!
    </div>

    <span class="tag-kategorija"><?php echo isset($category) ? $category : ''; ?></span>
    <h1><?php echo isset($title) ? $title : ''; ?></h1>
    <p class="sazetak"><?php echo isset($about) ? $about : ''; ?></p>
    
    <?php if(isset($picture) && $picture != '') { ?>
        <img src="img/<?php echo $picture; ?>" class="slika-clanka" alt="Slika članka">
    <?php } ?>
    
    <div class="tekst-clanka">
        <p><?php echo isset($content) ? nl2br($content) : ''; ?></p>
    </div>
</main>

<footer>
    <p>france.tv</p>
</footer>

</body>
</html>