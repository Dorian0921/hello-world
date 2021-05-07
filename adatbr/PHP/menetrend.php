

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
    <a href="menetrend.php" class="active">Menetrend</a>
    <a href="jegyvasarlas.php">Jegyvásárlás</a>
    <a href="index.php">Információ</a>
    <a href="register.php">Regisztráció</a>
    <a href="login.php">Bejelentkezés</a>
    <span> </span>
</div>

</body>
</html>

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
    $parancs="";
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
