<?php
include 'connect.php';

$id = $_GET['id'];
$query = "SELECT * FROM vijesti WHERE id=$id";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>FranceInfo - <?php echo $row['naslov']; ?></title>
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
        h1 { font-size: 32px; margin-bottom: 10px; color: #111; line-height: 1.3; }
        .datum { font-size: 12px; color: #888; margin-bottom: 20px; text-transform: uppercase; }
        .sazetak { font-size: 18px; font-style: italic; color: #555; margin-bottom: 30px; font-weight: bold;}
        .slika-clanka { width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px; margin-bottom: 30px; }
        .tekst-clanka { font-size: 16px; line-height: 1.8; color: #333; }
        
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

<main role="main">
    <span class="tag-kategorija"><?php echo $row['kategorija']; ?></span>
    <h1 class="title"><?php echo $row['naslov']; ?></h1>
    <p class="datum">OBJAVLJENO: <span><?php echo $row['datum']; ?></span></p>
    
    <section class="slika">
        <?php if($row['slika'] != '') { ?>
            <img src="img/<?php echo $row['slika']; ?>" class="slika-clanka">
        <?php } ?>
    </section>
    
    <section class="about">
        <p class="sazetak"><?php echo $row['sazetak']; ?></p>
    </section>
    
    <section class="sadrzaj">
        <div class="tekst-clanka">
            <p><?php echo nl2br($row['tekst']); ?></p>
        </div>
    </section>
</main>

<footer>
    <p>france.tv</p>
</footer>

</body>
</html>