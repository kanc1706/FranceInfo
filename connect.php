<?php
mysqli_report(MYSQLI_REPORT_OFF);

$servername = "127.0.0.1";
$username = "root";
$password = "";
$basename = "jutarnji";
$port = 3307;

$dbc = mysqli_connect($servername, $username, $password, $basename, $port);

if (!$dbc) {
    echo "<div style='background-color: #ffe6e6; color: #cc0000; padding: 15px; text-align: center; border: 1px solid #cc0000; font-weight: bold; margin-bottom: 20px;'>";
    echo "Upozorenje: Baza podataka nije spojena. Greška: " . mysqli_connect_error();
    echo "</div>";
} else {
    mysqli_set_charset($dbc, "utf8");
}
?>