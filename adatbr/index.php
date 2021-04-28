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
            <li class="menu_jelen"><a href="informacio.php">Információ</a></li>
            <li class="menu"><a href="login.php">Login</a></li>
            <li class="menu"><a href="registracio.php">Registráció</a></li>
        </ul>
    </nav>
</header>

<main>
    <section>
        <form method="post" astion="index.php">
          <label for="tabla">Lekérdezhető táblák:</label><br />
             <select name="tabla" id="tabla">
                 <option value="VA" selected>Városok</option>
                 <option value="UT">Utasok</option>
                 <option value="DO">Dolgozók</option>
                 <option value="VO">Vonatok</option>
                 <option value="RE">Rendezvények</option>
                 <option value="BE">Beosztás</option>
                 <option value="JE">Jegyek</option>
                 <input type="submit" value="Lekérdezés" name="keres">
             </select>
        </form>

        <?php
        session_start();
        $tablanev="VAROSOK";
        if(isset($_POST["keres"])){
            $keresett=$_POST["tabla"];
           switch($keresett){
               case "VA": $tablanev="VAROSOK" ;break;
               case "UT": $tablanev="utas";break;
               case "DO": $tablanev="dolgozok";break;
               case "VO": $tablanev="vonatok";break;
               case "RE": $tablanev="rendezveny";break;
               case "BE": $tablanev="beosztas";break;
               case "JE": $tablanev="jegy_ar";break;
               default:die("HIBA: valami elromlott");break;
           }
        }
        $conn = oci_connect('system', 'oracle', 'localhost/XE');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $stid = oci_parse($conn, 'select * from '.$tablanev);
        if (!$stid) {
            $e = oci_error($conn);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        echo "<table border='1'>\n";
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
        ?>
    </section>

</main>
</body>
<footer >
    <p >
        <br > FeMáLo Software Development Inc . Minden jog fentartva .
    </p >

</html>
