<?php
$conn=oci_connect("system","oracle","localhost/XE");
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$query = oci_parse($conn, "DELETE FROM UTAS WHERE USERNAME='" . $_GET["USERNAME"] . "'");
$result = oci_execute($query, OCI_DEFAULT);
if($result) {
    oci_commit($conn);
    echo "Sikeres törlés.";
}
else {
    echo "Hiba.";
}
oci_free_statement($query);
oci_close($conn);

?>

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

    <table>
        <tr>
            <td>Név</td>
            <td>Születési dátum</td>
            <td>E-mail cím</td>
            <td>Diák</td>
            <td>Nyugdíjas</td>
        </tr>
        <?php
        $i=0;
        while($row=oci_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $row["NEV"]; ?></td>
                <td><?php echo $row["SZULDATUM"]; ?></td>
                <td><?php echo $row["EMAIL"]; ?></td>
                <td><?php echo $row["DIAK"]; ?></td>
                <td><?php echo $row["NYUGDIJAS"]; ?></td>
                <td><a href="username=<?php echo $row["USERNAME"]; ?>">Törlés</a></td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </table>


</body>
</html>