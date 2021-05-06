<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/3d.css">
    <title>Információ</title>

</head>
<body>
<header>
    <h1>FeMáLo Software Development Inc.</h1>
    <nav>
        <ul>
            <li class="menu"><a href="menetrend.php">Menetrend</a></li>
            <li class="menu"><a href="jegyvasarlas.php">Jegyvásárlás</a></li>
            <li class="menu"><a href="index.php">Információ</a></li>
            <li class="menu"><a href="login.php">Login</a></li>
            <li class="menu_jelen"><a href="registracio.php">Registráció</a></li>
        </ul>
    </nav>
</header>

<main>
    <section id="varosmodosit">
        <form method="post" astion="index.php">
          <label for="tabla">Város hozzáadás:</label><br />
                 <label for="varosnev">Városnév</label><br>
                 <input required type="text" id="varosnev" name="varosnev" ><br>
                 <label for="dolgozoszam">Lakosszám</label><br>
                 <input required type="number" id="dolgozoszam" name="dolgozoszam" ><br>
                 <input type="submit" value="felvetel" name="felvetel">
        </form>
    </section>


    <?php
        session_start();
        $varosnev="";
        $dolgozoszam=0;
        $paramcs="";
        if(isset($_POST["felvetel"])) {
            $varosnev = $_POST["varosnev"];
            $dolgozoszam = $_POST["dolgozoszam"];
            $parancs = "INSERT INTO VAROSOK(VAROSNEV,DOLGOZOK_SZAMA)VALUES(" . "'$varosnev'" . "," . "$dolgozoszam" . ")";

            $conn = oci_connect('system', 'oracle', 'localhost/XE');
            if (!$conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            $stid = oci_parse($conn, $parancs);
            if (!$stid) {
                $e = oci_error($conn);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            $r = oci_execute($stid);
            if (!$r) {
                $e = oci_error($stid);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            oci_free_statement($stid);
            oci_close($conn);
        }
        ?>


</main>
</body>
<footer >
    <p >
        <br > FeMáLo Software Development Inc . Minden jog fentartva .
    </p >

</html>
