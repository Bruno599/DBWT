<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkte.html</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
</head>
<body>

<?php
include ('snippets/navbaroben.php')
?>

<!-- #00b5ad  Farbcode der Links-->

<div class="container">
    <div class="row m-4">
        <div class="col-2 ml-3">
        </div>
        <div class="col text-left ">
            <h2>Verfügbare Speisen (Bestseller)</h2>
        </div>
    </div>
    <div class="row m-2">
        <div class="col-2 border m-2 border-dark">
           <form>
               <fieldset>
                   <legend class="text-nowrap text-hide">Speisenliste filter</legend>
                   <p class="on_line text-center">Speisenliste filter</p>

                   <input type="search" list="kategorien" class="w-100 mb-5 mt-5 " placeholder="Kategorien">
                   <datalist id="kategorien">
                       <option value="Tagesmenü">
                       <option value="Classiker">
                       <option value="Pizza">
                   </datalist>

                   <input type="checkbox" class="m-2 "> nur verfügbar
                   <input type="checkbox" class="m-2"> nur vegetarisch
                   <input type="checkbox" class="m-2"> nur vegan

                   <button type="button" class="mt-5 ">Speisen filtern</button>
               </fieldset>

           </form>
        </div>
        <div class="col" id="body_produkte">
            <div class="row text-center">
                <div class="col m-2 ">
                    <img src="pictures/platzhalter_essen.jpg" alt="sorry I'am Broken">
                </div>
                <div class="col m-2">
                    <img src="pictures/platzhalter_essen.jpg" alt="sorry I'am Broken">
                </div>
                <div class="col m-2 passdout">
                    <img src="pictures/platzhalter_essen.jpg" alt="sorry I'am Broken">
                </div>
                <div class="col m-2">
                    <img src="pictures/platzhalter_essen.jpg" alt="sorry I'am Broken">
                </div>

            </div>
            <div class="row text-center">
                <div class="col ">
                    Curry Wok <br>
                    <a href="Detail.php" class="fh_color"> Details</a>
                </div>
                <div class="col ">
                    Schnitzel <br>
                    <a href="Detail.php" class="fh_color"> Details</a>
                </div>
                <div class="col passdout">
                    Bratrolle <br>
                    <a>vergriffen</a>
                </div>
                <div class="col ">
                    Krautsalat <br>
                    <a href="Detail.php" class="fh_color"> Details</a>
                </div>

            </div>
            <div class="row text-center">
                <div class="col m-2">
                    <img src="pictures/platzhalter_essen.jpg" alt="sorry I'am Broken">
                </div>
                <div class="col m-2">
                    <img src="pictures/platzhalter_essen.jpg" alt="sorry I'am Broken">
                </div>
                <div class="col m-2">
                    <img src="pictures/platzhalter_essen.jpg" alt="sorry I'am Broken">
                </div>
                <div class="col m-2">
                    <img src="pictures/platzhalter_essen.jpg" alt="sorry I'am Broken">
                </div>

            </div>
            <div class="row text-center">
                <div class="col ">
                    Falafel <br>
                    <a href="Detail.php" class="fh_color"> Details</a>
                </div>
                <div class="col ">
                    Currywurst <br>
                    <a href="Detail.php" class="fh_color"> Details</a>
                </div>
                <div class="col ">
                    Käsestulle <br>
                    <a href="Detail.php" class="fh_color"> Details</a>
                </div>
                <div class="col ">
                    Spiegelei <br>
                    <a href="Detail.php" class="fh_color"> Details</a>
                </div>

            </div>
        </div>
        <div class="col-1">
            <!-- nur zum einrücken -->
        </div>

    </div>
</div>

<?php
include ('snippets/navbarunten.php')
?>


</body>
</html>