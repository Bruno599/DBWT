<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Start.html</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
</head>
<body>
@include('navbaroben')

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
            @if(isset($_SESSION['aktive']))
                <p>Sie sind angemdeldet</p>
                @else
                <form action="Registration.php">
                    <button type="submit" class="mt-2 mb-2 w-100" id="registrieren">
                        <img class="img symbol float-md-left ml-2" src="button/svgs/solid/hand-point-right.svg" alt="platzhalter">
                        Registrieren
                    </button>
                </form>
                <form action="Login.php">
                    <button type="submit" class="mt-2 mb-2 w-100" id="anmelden" >
                        <img class="img symbol float-md-left ml-2" src="button/svgs/solid/sign-in-alt.svg" alt="platzhalter">
                        Anmelden
                    </button>
                </form>
                @endif
        </div>
    </div>
</div>
<div class="container mt-4 mb-4 align-items-center">
    <div class="row">
        @if(isset($_SESSION['aktive']))
            <div class="col-3" id="text3_left_start">
            Die Funktion ist leider noch nicht verfügbar!
            </div>
            @else
        <div class="col-3" id="text3_left_start">
            Registrieren Sie sich <a class="fh_color" href="Registration.php">hier</a>, um über die Veröffentlichung des Dienstes per Mail informiert zu werden.
        </div>
        @endif
        <div class="col-9" id="picture2_right_start">
            <img class="img-fluid" src="pictures/platzhalter.jpg" alt="Platzhalter">
        </div>
    </div>
</div>


@include('navbarunten')

</body>
</html>
