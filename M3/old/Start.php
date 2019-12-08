<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Start.html</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
include ('snippets/navbaroben.php')
?>

    <!-- #00b5ad  Farbcode der Links-->

    <div class="container body_container">
        <div class="row mt-4">
        <div class="col-12 float-md-none">
            <img class="img" id="picture1_centre_start" src="pictures/platzhalter.jpg" alt="Platzhalter">
        </div>
        </div>
    </div>
    <div class="container align-content-center mt-4">
        <div class="row">
            <div class="col-3" id="text1_left_start">
                Der Dienst e-Mensa ist noch beta. Sie können bereits <a class="fh_color" href="Produkte.php">Mahlzeiten</a> durchstöbern, aber noch nicht bestellen.
            </div>
            <div class="col-7" id="Text2_centre_start">
                <h1 class="text-nowrap">Leckere Gerichte vorbestellen</h1>
                <br> <p>... und gemeinsam mit Kommilitonen und Freunden essen</p>
            </div>
            <div class="col-2" id="buttons_right_start">
                <button type="button" class="mt-2 mb-2 w-100" id="registrieren">
                    <img class="img symbol float-md-left ml-2" src="button/svgs/solid/hand-point-right.svg" alt="platzhalter">
                    Registrieren
                </button>
                <button type="button" class="mt-2 mb-2 w-100" id="anmelden">
                    <img class="img symbol float-md-left ml-2" src="button/svgs/solid/sign-in-alt.svg" alt="platzhalter">
                    Anmelden
                </button>
            </div>
        </div>
    </div>
    <div class="container mt-4 mb-4 align-items-center">
        <div class="row">
            <div class="col-3" id="text3_left_start">
                Registrieren Sie sich <a class="fh_color" href="">hier</a>, um über die Veröffentlichung des Dienstes per Mail informiert zu werden.
            </div>
            <div class="col-9" id="picture2_right_start">
                <img class="img-fluid" src="pictures/platzhalter.jpg" alt="Platzhalter">
            </div>
        </div>
    </div>


<?php
include ('snippets/navbarunten.php')
?>

</body>
</html>