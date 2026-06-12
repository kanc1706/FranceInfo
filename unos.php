<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FranceInfo - Administracija</title>
    
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

        .forma-centar {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 50px 20px;
            width: 100%;
            flex: 1; 
        }
        .fensi-forma {
            background: #ffffff;
            width: 100%;
            max-width: 650px;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            border: 1px solid #eaeaea;
        }
        .fensi-forma h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #111;
            text-transform: uppercase;
            font-size: 22px;
            letter-spacing: 1px;
        }
        .form-grupa { margin-bottom: 20px; }
        .form-grupa label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-grupa input[type="text"],
        .form-grupa textarea,
        .form-grupa select {
            width: 100%;
            padding: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #fdfdfd;
        }
        .form-grupa input[type="text"]:focus,
        .form-grupa textarea:focus,
        .form-grupa select:focus {
            border-color: #f5a623;
            outline: none;
            box-shadow: 0 0 0 4px rgba(245, 166, 35, 0.15);
            background-color: #ffffff;
        }
        .form-grupa textarea { height: 130px; resize: vertical; }
        .form-grupa-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .form-grupa-check label { margin: 0; font-size: 15px; text-transform: none; font-weight: normal; }
        .form-grupa-check input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background-color: #f5a623;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        .btn-submit:hover {
            background-color: #df9116;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(223, 145, 22, 0.3);
        }

        footer { background-color: #f8f9fa; text-align: right; padding: 40px 80px; margin-top: auto; font-size: 12px; color: #888; border-top: 1px solid #eaeaea; }

        @media (max-width: 768px) {
            nav ul { gap: 30px; }
            .fensi-forma { padding: 30px 20px; }
        }
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
        <li><a href="tecaj.php">tecaj</a></li>
        <li><a href="unos.html">administracija</a></li>
    </ul>
</nav>

<div class="forma-centar">
    <div class="fensi-forma">
        <h1>Unos nove vijesti</h1>
        <form action="skripta.php" method="POST" enctype="multipart/form-data">
            <div class="form-grupa">
                <label>Naslov:</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-grupa">
                <label>Kratki sadržaj (do 50 znakova):</label>
                <textarea name="about" maxlength="50" required></textarea>
            </div>
            
            <div class="form-grupa">
                <label>Tekst vijesti:</label>
                <textarea name="content" required></textarea>
            </div>
            
            <div class="form-grupa">
                <label>Slika (Upload):</label>
                <input type="file" name="pphoto" required>
            </div>
            
            <div class="form-grupa">
                <label>Kategorija:</label>
                <select name="category">
                    <option value="elections">Elections</option>
                    <option value="lesjt">Les JT</option>
                </select>
            </div>
            
            <div class="form-grupa form-grupa-check">
                <input type="checkbox" name="archive" id="arhiva">
                <label for="arhiva">Spremi kao skriveno (Arhiva)</label>
            </div>
            
            <button type="submit" name="submit" class="btn-submit">Objavi vijest</button>
        </form>
    </div>
</div>

<footer>
    <p>france.tv</p>
</footer>

</body>
</html>