

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
    <img id="varoskeres">
        <form method="post" action="menetrend.php">
            <select name="varos" id="varos">
                <option value="Budapest" selected>Budapest</option>
                <option value="Tatabanya" >Tatabánya</option>
                <option value="Eger">Eger</option>
                <option value="Szolnok">Szolnok</option>
                <option value="Kecskemet">Kecskemét</option>
                <option value="Szekesfehervar">Székesfehérvár</option>
                <option value="Salgotarjan">Salgótarján</option>
                <option value="Miskolc">Miskolcs</option>
                <option value="Nyiregyhaza">Nyíregháza</option>
                <option value="Debrecen">Debrecen</option>
                <option value="Bekescsaba">Békéscsaba</option>
                <option value="Szekszard">Szekszárd</option>
                <option value="Kaposvar">Kaposvár</option>
                <option value="Veszprem">Veszprém</option>
                <option value="Pecs">Pécs</option>
                <option value="Zalaegerszeg">Zalaegerszeg</option>
                <option value="Szombathely">Szombathely</option>
                <option value="Gyor">Győr</option>
                <option value="Szeged">Szeged</option>
            </select>

            <select name="varos2" id="varos2">
                <option value="Budapest">Budapest</option>
                <option value="Tatabanya"  selected>Tatabánya</option>
                <option value="Eger">Eger</option>
                <option value="Szolnok">Szolnok</option>
                <option value="Kecskemet">Kecskemét</option>
                <option value="Szekesfehervar">Székesfehérvár</option>
                <option value="Salgotarjan">Salgótarján</option>
                <option value="Miskolc">Miskolcs</option>
                <option value="Nyiregyhaza">Nyíregháza</option>
                <option value="Debrecen">Debrecen</option>
                <option value="Bekescsaba">Békéscsaba</option>
                <option value="Szekszard">Szekszárd</option>
                <option value="Kaposvar">Kaposvár</option>
                <option value="Veszprem">Veszprém</option>
                <option value="Pecs">Pécs</option>
                <option value="Zalaegerszeg">Zalaegerszeg</option>
                <option value="Szombathely">Szombathely</option>
                <option value="Gyor">Győr</option>
                <option value="Szeged">Szeged</option>
            </select>
            <input type="submit" value="mutat" name="mutat">

        </form>

        <img src="../Images/menetterkep.jpg" style="display: inline; width: 800px;float: right">
    </section>

    <?php
    session_start();

    $parancs="";
    $indulovaros="";
    $erkezovaros="";
    $koztes="";


    if(isset($_POST["mutat"])) {
        $conn = oci_connect('system', 'oracle', 'localhost/XE');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $kereso[0] = array(
            "indulas" => $_POST["varos"],
            "erkezes" => $_POST["varos2"],
            "koztes" => "A"
        );

        $tablanev = "MENETRENDEK";
        $indulovaros = $kereso[0]["indulas"];
        $erkezovaros = $kereso[0]["erkezes"];

        $parancs = "SELECT indulo_varos,
                    erkezo_varos,
                    to_char(extract(hour from induloidopont))||to_char(':')||trim(to_char(extract(minute from induloidopont),'00'))as induloidopont,
                    to_char(extract(hour from erkezoidopont))||to_char(':')||trim(to_char(extract(minute from erkezoidopont),'00'))as erkezoidopont
                     FROM "
                    .$tablanev
                    ." WHERE"
                    ." INDULO_VAROS='$indulovaros'"
                    ." AND"
                    ." ERKEZO_VAROS='$erkezovaros'";

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

        echo "<table style='background-color:white' border='1'>\n";
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            echo "<tr>\n";
            foreach ($row as $item) {
                echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
        oci_free_statement($stid);
        oci_close($conn);
    }

    /*
    // $varosnev="";
   // $dolgozoszam=0;
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
        }*/
    ?>


</main>
