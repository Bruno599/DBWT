<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__,'connection.env');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);

// Legen Sie die Datei in xampp/htdocs/ ab und öffnen Sie mit dem Browser localhost:8080/Uploader.php
// Ändern Sie die Zeile 12 auf Ihre Zugangsdaten und Datenbank ab.

// wenn es Sie interessiert, wie das $_FILES Array aussieht, kommentieren Sie die folgende Zeile aus
// echo "<pre>".print_r($_FILES,1)."</pre>";

if(count($_FILES)>0) {
    $f = array_pop($_FILES);
    $text = $_POST["alt-text"];
    $titel = $_POST["Titel"];
    $content = file_get_contents($f['tmp_name']); // bitte nicht ändern
    $remote = mysqli_connect(getenv('DB_HOST'),getenv('DB_USER'),getenv('DB_PASS'),getenv('DB_NAME'));
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MariaDB: " . mysqli_connect_error();
    }

    $query =
        "INSERT INTO Bilder (`Alt-Text`, `Titel`, `Binärdaten`) ".
        "VALUES ('".$text."','".$titel."','".mysqli_real_escape_string($remote,$content)."');";

    // Wenn die Query mit den Binärdaten nicht funktionieren sollte,
    // nutzen Sie die folgende:

    /*$query =
        "INSERT INTO Bilder (`Alt-Text`, `Title`, `Binärdaten`) ".
        "VALUES ('NoPic','NoTitle','".base64_encode($content)."');";
    */

    // wenn Sie die erzeugte Query interessiert (Debug):
    echo "
    <p>Ihre Query an den DB-Server lautete:</p>
    <pre>$query</pre>";

    $result = mysqli_query($remote,$query);
    if($result==1)
        $message = "Bild hochgeladen.";
    else
        $message = "Bild wurde nicht hochgeladen.";
}
else {
    $message = "Wählen Sie ein Bild für den Upload aus.";
}
?>

<html>
<head><title>Upload</title>
    <style>body>div{margin:20% auto; width: 50%;</style>
</head>
<body>
<div>
<form enctype="multipart/form-data" action="#" method="post">
    <fieldset>
    <legend><?php echo $message; ?></legend>
        <div>
    <label class="w-50" for="bild">Bild auswählen</label>
    <input type="file" accept="image/*" required name="bild" id="bild">
        </div>
        <div>
            <label for="alt-text">Alternativ Text:</label>
            <input type="text" required name="alt-text" id="alt-text">
        </div>
        <div>
            <lable for="Titel">Titel des Bildes:</lable>
            <input type="text" required name="Titel" id="Titel">
        </div>
        <div>
    <input type="submit" value="Hochladen">
        </div>
    </fieldset>
</form>
</div>
</body>
</html>




