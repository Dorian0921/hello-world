<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="../css/login.css"/>
</head>
<body>
<div class="header">
    <img src="../Images/trainlogo.png" alt="Train Logo" height="150" width="150" >
    <a href="menetrend.php">Menetrend</a>
    <a href="jegyvasarlas.php">Jegyvásárlás</a>
    <a href="index.php">Információ</a>
    <a href="register.php">Regisztráció</a>
    <a href="login.php" class="active">Bejelentkezés</a>
    <span> </span>
</div>

<form action="login.php" method="post">
    <div class="container">
        <h1>Bejelentkezés</h1>
        <p>Kérem töltse ki az alábbi mezőket</p>

        <hr>

        <label><b>Név</b></label>
        <input type="text" placeholder="Adja meg a nevét!" name="username">

        <label><b>E-mail</b></label>
        <input type="email" placeholder="Adja meg E-mail címét!" name="email">

        <label><b>Jelszó</b></label>
        <input type="password" placeholder="Adja meg a jelszavát!" name="pw">

        <label>
            <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Adatok megjegyzése
        </label>

        <div class="fix">
            <button type="submit" name="login">Bejelentkezés</button>
            <button type="reset" id="buttonres">Adatok törlése</button>
        </div>

        <h2>Nincs még fiókja? Regisztráljon itt: <a href="register.php" class="notwhite"> Regisztráció</a></h2>
    </div>
</form>

</body>
</html>


