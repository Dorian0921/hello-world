<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../css/register.css">
    <title>Információ</title>

</head>
<body>
<div class="header">
    <img src="../Images/trainlogo.png" alt="Train Logo" height="150" width="150" >
    <a href="menetrend.php">Menetrend</a>
    <a href="jegyvasarlas.php">Jegyvásárlás</a>
    <a href="index.php">Információ</a>
    <a href="register.php" class="active">Regisztráció</a>
    <a href="login.php">Bejelentkezés</a>
    <span> </span>
</div>

<form action="register.php" method="post">
    <div class="container">
        <h1>Regisztráció</h1>
        <p>Kérem töltse ki az alábbi mezőket</p>
        <hr>

        <label><b>Név</b></label>
        <input type="text" placeholder="Adjon meg egy tetszőleges felhasználónevet!" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">

        <label><b>E-mail</b></label>
        <input type="email" placeholder="Adja meg E-mail címét!" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">

        <label><b>Jelszó</b></label>
        <input type="password" placeholder="Adja meg a jelszavát!" name="pw">

        <label><b>Jelszó mégegyszer</b></label>
        <input type="password" placeholder="Adja meg a jelszavát mégegyszer!" name="pw-repeat">
        <hr>

        <button type="submit" name="register" class="registerbtn">Regisztráció</button>

        <h2>Már regisztrált? Lépjen vissza az bejelentkezéshez itt:<a href="login.php" class="notwhite"> Bejelentkezés</a></h2>
    </div>

</body>
</html>
