<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Start.html</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container border-bottom border-dark">
            <div class="row align-items-baseline">
                <div class="col-3 text-nowrap">
                    <h1 class="fh_color">e-Mensa</h1>
                </div>
                <div class="pr-2 pl-2 col-1 text-right ">
                    <a>Start</a>
                </div>
                <div class="pr-2 pl-2 col-1 border-left border-dark text-center">
                    <a class="fh_color" href="Produkte.html">Mahlzeiten</a>
                </div>
                <div class="pr-2 pl-2 col-1 border-left border-dark text-center">
                    <a class="fh_color" href="">Bestellung</a>
                </div>
                <div class="pr-2 pl-2 col-1 border-left border-dark text-center text-nowrap">
                    <a class="fh_color" href="https://www.fh-aachen.de" target="_blank">FH-Aachen</a>
                </div>
                <div class="col-5 text-right text-nowrap mb-2 ">
                    <form action="http://www.google.de/search" target="_blank" method="get">
                        <div class="text-right border float-right rounded">
                            <button class="rounded p-0 border-0 mr-0"><i id="searchBar"></i></button>
                            <input class="rounded ml-0 border-0" type="search" name="q" placeholder="Suche">
                            <input type="hidden" name="as_sitesearch" value="http://www.fh-aachen.de">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

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
                Der Dienst e-Mensa ist noch beta. Sie können bereits <a class="fh_color" href="Produkte.html">Mahlzeiten</a> durchstöbern, aber noch nicht bestellen.
            </div>
            <div class="col-7" id="Text2_centre_start">
                <p>
                    <?php
                    $time = date("H:i");
                    echo "Wir haben  $time Uhr und du kannst jetzt schon ...";
                    ?>
                </p>
                <h1 class="text-nowrap"> Leckere Gerichte vorbestellen</h1>
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


    <footer>
        <div class="container border-top border-dark ">
            <div class="row align-items-center mw-100 mt-2">
                <div class="col-3">
                    (c) <?php echo date("Y") ?> DBWT
                </div>
                <div class="col-1 pr-2 pl-2 text-right">
                    <a class="fh_color" href="">Login</a>
                </div>
                <div class="col-auto border-left border-dark text-center pr-2 pl-2">
                    <a class="fh_color" href="">Registrieren</a>
                </div>
                <div class="col-auto border-left border-dark text-center pr-2 pl-2">
                    <a class="fh_color" href="">Zutatenliste</a>
                </div>
                <div class="col-1 border-left border-dark text-center pr-2 pl-2">
                    <a class="fh_color" href="Impressum.html">Impressum</a>
                </div>
                <div class="col">

                </div>
            </div>
        </div>
    </footer>

</body>
</html>