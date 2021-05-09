<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adatekérdezés</title>
    <link rel="stylesheet" href="../css/login.css"/>
</head>
<body>
<div class="header">
    <img src="../Images/trainlogo.png" alt="Train Logo" height="150" width="150" >
    <a href="menetrend.php">Menetrend</a>
    <a href="jegyvasarlas.php" class="active">Jegyvásárlás</a>
    <a href="index.php">Információ</a>
    <a href="register.php">Regisztráció</a>
    <a href="login.php">Bejelentkezés</a>
    <span> </span>
</div>
<section>
    <form method="post" action="jegyvasarlas.php">
        <select name="lekeres" id="lekeres">
            <option value="1"  selected>Munkabérszámítás</option>
            <option value="2">Mennyit kerestünk városokra leosztva</option>
            <option value="3">Hány százalék utazik kedvezményesen</option>
            <option value="4">Profit</option>
            <option value="5">Leggyorsabb vonatunk nevének kiírása</option>
            <option value="6">menetrendek</option>
            <option value="7">tul keves munkás az állomáson</option>
            <option value="8">honnan utazott a legtöbb ember</option>
            <option value="9">nyári rendezvények</option>

        </select>
        <input type="submit" value="leker" name="leker">
    </form>

     <?php
    session_start();

     if(isset($_POST["leker"])) {
         $conn = oci_connect('system', 'oracle', 'localhost/XE');
         if (!$conn) {
             $e = oci_error();
             trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
         }

         $parancs="";
         $lekert=$_POST["lekeres"];
         switch($lekert){
             case "1": $parancs="SELECT dolgozok.username,((EXTRACT(DAY FROM meddig)-EXTRACT(DAY FROM mettol))*dolgozok.ber*8*4) AS Haviber from beosztas inner join dolgozok on beosztas.username=dolgozok.username Where dolgozok.username='kovetkezetes_acsalapu_ormanyos'" ;break;
             case "2": $parancs="Select (EXTRACT(Year FROM idopont))as ev,honnan, sum(ar) as Bevetel from Eladottjegyek group by (EXTRACT(Year FROM idopont)),honnan order by ev" ;break;
             case "3": $parancs="Select Count(*) into osszesjegy from eladottjegyek;Select Round(Count(utas.username)/osszesjegy*100,2) into szazalek from utas inner join eladottjegyek on utas.username=eladottjegyek.username where diak=1 or nyugdijas=1" ;break;
             case "4": $parancs="Select Sum(ar) into bevetel from eladottjegyek where EXTRACT(Year FROM idopont)=EXTRACT(Year FROM SYSDATE) and EXTRACT(Month FROM idopont)=EXTRACT(Month FROM SYSDATE);  SELECT SUM((EXTRACT(DAY FROM meddig)-EXTRACT(DAY FROM mettol))*dolgozok.ber*8*4) AS Haviber into kiadas from beosztas inner join dolgozok on beosztas.username=dolgozok.username ;profit := bevetel-kiadas" ;break;
             case "5": $parancs="Select vonatok.nev, indulo_varos,erkezo_varos, EXTRACT(minute FROM(erkezoidopont-induloidopont))as perc from menetrendek inner join vonatok on menetrendek.szerelveny_szam=vonatok.szerelveny_szam order by perc FETCH FIRST 1 rows only" ;break;
             case "6": $parancs="select indulo_varos,
erkezo_varos,
to_char(extract(hour from induloidopont))||to_char(':')||trim(to_char(extract(minute from induloidopont),'00'))as induloidopont,
to_char(extract(hour from erkezoidopont))||to_char(':')||trim(to_char(extract(minute from erkezoidopont),'00'))as erkezoidopont
from menetrendek" ;break;
             case "7": $parancs="Select varos,foglalkozas, Count(foglalkozas)as darab  from dolgozok  group by varos, foglalkozas having Count(foglalkozas)<5 order by varos" ;break;
             case "8": $parancs="select honnan,Count(username) from eladottjegyek group by honnan order by Count(username) desc FETCH FIRST 1 rows only" ;break;
             case "9": $parancs="select helyszin, to_char(extract(year from idopont))||
to_char('.')||trim(to_char(extract(month from idopont),'00'))||
to_char('.')||trim(to_char(extract(day from idopont),'00'))||to_char('.')as induloidopont,
rendezvenynev 
from rendezveny
where extract(month from idopont)>5 and extract(month from idopont)<9" ;break;
             case "10": $parancs="" ;break;
             case "11": $parancs="" ;break;
             case "12": $parancs="" ;break;
             case "13": $parancs="" ;break;
             case "14": $parancs="" ;break;
             case "15": $parancs="" ;break;
             case "16": $parancs="" ;break;
             case "17": $parancs="" ;break;
             case "18": $parancs="" ;break;
             case "19": $parancs="" ;break;
             default:die("HIBA: valami elromlott");break;
         }


         //$parancs = "SELECT * FROM MENETRENDEK";

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
    ?>

</section>
</body>
</html>