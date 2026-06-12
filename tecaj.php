<?php
include 'connect.php';

$apiKey = "4f8b8d76d173f2fd3f9657e8";
$url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/EUR";

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$tecajHRK = isset($data['conversion_rates']['HRK']) ? $data['conversion_rates']['HRK'] : 'N/A';
$tecajUSD = isset($data['conversion_rates']['USD']) ? $data['conversion_rates']['USD'] : 'N/A';
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Tečajna lista - FranceInfo</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #fdfdfd; display: flex; flex-direction: column; min-height: 100vh; }
        nav { border-top: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0; width: 100%; background-color: #ffffff; }
        nav ul { list-style-type: none; display: flex; justify-content: center; gap: 80px; padding: 15px 20px; flex-wrap: wrap; }
        nav ul li a { text-decoration: none; color: #000; font-weight: bold; text-transform: lowercase; font-size: 14px; }
        main { max-width: 600px; margin: 40px auto; padding: 40px; background: #fff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; }
        h1 { margin-bottom: 30px; }
        .tecaj-box { font-size: 20px; padding: 15px; border: 1px solid #eee; margin: 10px 0; }
        footer { background-color: #f8f9fa; text-align: right; padding: 40px 80px; margin-top: auto; font-size: 12px; color: #888; border-top: 1px solid #eaeaea; }
    </style>
</head>
<body>

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
    <h1>Tečaj EUR (baza)</h1>
    <div class="tecaj-box">1 EUR = <strong><?php echo $tecajHRK; ?> HRK</strong></div>
    <div class="tecaj-box">1 EUR = <strong><?php echo $tecajUSD; ?> USD</strong></div>
</main>

<footer>
    <p>france.tv</p>
</footer>

</body>
</html>