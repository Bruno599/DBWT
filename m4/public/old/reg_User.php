
<?php



$array1 = [
    1 => "vorname",
    2 => "nachname",
    3 => "passwort",
    4 => "e_mail",
    5 => "nutzername",
    6 => "geburtsdatum"
];
$array2[] = 0;

for ($i = 1; $i <= 6; $i++) {
    if (isset($_POST[$array1[$i]])) {
        $array2[$i] = $_POST[$array1[$i]];
    }
}

$array2[3] = password_hash($array2[3], PASSWORD_DEFAULT);

$query = "INSERT INTO Benutzer(`E-Mail`, Bild, Nutzername, `Anlege Datum`, Aktiv, Vorname, Nachname, Geburtsdatum, `Letzter Login`, Hash) 
VALUES ('$array2[4]', 0, '$array2[5]', CURRENT_DATE, 0, '$array2[1]', '$array2[2]', '2001-01-01', NOW(), '$array2[3]');";

$result = mysqli_query($remoteConnection, $query);

$int = mysqli_affected_rows($remoteConnection);

if($int >= 1)
{
    $redirect = "Start.php";
}
else{
    $redirect = "Registration.php";
}
/*echo $array2[1];
echo $array2[2];
echo $array2[3];
echo $array2[4];
echo $array2[5];
echo $array2[6];*/

echo "<!DOCTYPE html>
<html lang=\"de\">
<head>
    <meta charset=\"UTF-8\">
    <meta http-equiv=\"refresh\" content=\"3; URL=".$redirect. 'snippets/mysqlconnect.php';

include ('snippets/navbaroben.php');




echo "<div class='container'>";

if ($int >= 1)
{
    echo '<div class="row"><h1>Ihre Registrierung hat geklappt!</h1></div>';
}
else
{
    echo '<div class="row"><h1>Ihre Registrierung hat leider nicht geklappt!</h1></div>';
}

mysqli_close($remoteConnection);

echo "</div>";

include ('snippets/navbarunten.php');

echo "

</body>
</html>";
