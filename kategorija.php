<?php
include 'connect.php';
$kategorija = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>FranceInfo - <?php echo ucfirst($kategorija); ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #fdfdfd; color: #333333; display: flex; flex-direction: column; min-height: 100vh; overflow-x: hidden; }
        header { max-width: 1200px; margin: 0 auto; padding: 20px 20px 0 20px; width: 100%; text-align: left; }
        .logo { font-size: 36px; font-weight: bold; margin-bottom: 20px; color: #000; }
        .logo span { color: #f5a623; }
        nav { border-top: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0; width: 100%; background-color: #ffffff; }
        nav ul { list-style-type: none; display: flex; justify-content: center; gap: 80px; padding: 15px 20px; flex-wrap: wrap; }
        nav ul li a { text-decoration: none; color: #000; font-weight: bold; text-transform: lowercase; font-size: 14px; transition: color 0.3s; }
        nav ul li a:hover { color: #f5a623; }
        
        main { max-width: 1200px; margin: 0 auto; padding: 40px 20px; flex: 1; width: 100%; }
        .kategorija { position: relative; margin-bottom: 50px; }
        .kategorija h1 { text-transform: uppercase; font-size: 18px; margin-bottom: 20px; color: #000; }
        .vijesti { display: grid; gap: 20px; grid-template-columns: repeat(4, 1fr); }
        
        .kartica { transition: transform 0.2s ease; }
        .kartica:hover { transform: translateY(-5px); }
        .kartica img { width: 100%; aspect-ratio: 16 / 9; object-fit: cover; display: block; margin-bottom: 10px; border-radius: 4px; }
        .kartica a { text-decoration: none; color: #000; font-size: 13px; line-height: 1.4; font-weight: bold; display: block; }
        
        footer { background-color: #f8f9fa; text-align: right; padding: 40px 80px; margin-top: auto; font-size: 12px; color: #888; width: 100%; border-top: 1px solid #eaeaea; }

        @media (max-width: 1024px) { .vijesti { grid-template-columns: repeat(3, 1fr); } nav ul { gap: 40px; } }
        @media (max-width: 768px) { .vijesti { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .vijesti { grid-template-columns: 1fr; } nav ul { gap: 20px; flex-direction: column; align-items: center; } }
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
    <section class="kategorija">
        <h1><?php echo $kategorija; ?></h1>
        <div class="vijesti">
            <?php
            $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='$kategorija' ORDER BY id DESC";
            $result = mysqli_query($dbc, $query);
            
            while($row = mysqli_fetch_array($result)) {
                echo '<article class="kartica">';
                echo '<a href="clanak.php?id='.$row['id'].'">';
                echo '<img src="img/'.$row['slika'].'" alt="Slika vijesti">';
                echo '<p>'.$row['naslov'].'</p>';
                echo '</a>';
                echo '</article>';
            }
            ?>
        </div>
    </section>
</main>

<footer>
    <p>france.tv</p>
</footer>

</body>
</html>