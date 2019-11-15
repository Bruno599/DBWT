
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
                    <?php
                    if ($_SERVER['REQUEST_URI'] == "/DBWT/M2/Zutaten.php") {
                        echo "<a>Zutatenliste</a>";
                    }
                    else {
                        echo "<a class=\"fh_color\" href=\"Zutaten.php\">Zutatenliste</a>";
                    }
                    ?>

                </div>
                <div class="col-1 border-left border-dark text-center pr-2 pl-2">
                    <?php
                    if ($_SERVER['REQUEST_URI'] == "/DBWT/M2/Impressum.php") {
                        echo "<a>Impressum</a>";
                    }
                    else {
                        echo "<a class=\"fh_color\" href=\"Impressum.php\">Impressum</a>";
                    }
                    ?>

                </div>
                <div class="col">

                </div>
            </div>
        </div>
    </footer>
