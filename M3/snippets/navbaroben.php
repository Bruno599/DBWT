
<header>
        <div class="container border-bottom border-dark">
            <div class="row align-items-baseline">
                <div class="col-3 text-nowrap">
                    <h1 class="fh_color">e-Mensa</h1>
                </div>
                <div class="pr-2 pl-2 col-1 text-right ">
                    <?php
                    if (basename($_SERVER['PHP_SELF']) == "Start.php") {
                        echo "<a>Start</a>";
                    }
                    else {
                        echo "<a class='fh_color' href='Start.php'>Start</a>";
                    }
                    ?>
                </div>
                <div class="pr-2 pl-2 col-1 border-left border-dark text-center">
                    <?php
                    if (basename($_SERVER['PHP_SELF'])== "Produkte.php") {
                        echo "<a>Mahlzeiten</a>";
                    }
                    else {
                        echo"<a class='fh_color' href='Produkte.php?limit=4'>Mahlzeiten</a>";
                    }
                    ?>
                </div>
                <div class="pr-2 pl-2 col-1 border-left border-dark text-center">
                    <?php
                    if (basename($_SERVER['PHP_SELF']) == "Bestellung.php") {
                        echo "<a>Bestellung</a>";
                    }
                    else {
                        echo "<a class='fh_color' href=''>Bestellung</a>";
                    }
                    ?>
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
