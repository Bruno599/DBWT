<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkte.html</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
    <?php
    include ('snippets/mysqlconnect.php')
    ?>
</head>
<body>

<?php
include ('snippets/navbaroben.php')
?>

<!-- #00b5ad  Farbcode der Links-->
<?php

$limit1 = $_GET["limit"];
$avail = $_GET["avail"];
if($avail) {
    if($limit1 > 0) {
        $query="select ID, Name, Verfügbar FROM Mahlzeiten WHERE Verfügbar = true LIMIT $limit1";
    }
    else {
            $query="select ID, Name, Verfügbar FROM Mahlzeiten WHERE Verfügbar = true";
        }
}
else {
    if($limit1 > 0) {
        $query="select ID, Name, Verfügbar FROM Mahlzeiten LIMIT $limit1";
    }
    else {
        $query="select ID, Name, Verfügbar FROM Mahlzeiten";
    }
}


$result = mysqli_query($remoteConnection, $query);

echo
'<div class="container">
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

                   <input type="checkbox" class="m-2"> nur verfügbar
                   <input type="checkbox" class="m-2"> nur vegetarisch
                   <input type="checkbox" class="m-2"> nur vegan

                   <button type="button" class="mt-5">Speisen filtern</button>
               </fieldset>
           </form>
        </div>
      
        <div class="col" id="body_produkte">';


for($j = 0;$j <= 2;$j++)
    {

        echo '<div class="row text-center">';
            for($i = 0;$i <4;$i++)
                {
                    if ($row = mysqli_fetch_assoc($result)) {

                        $value = $row['ID'];
                        $query1 = "SELECT Mahlzeiten.ID, B.Binärdaten FROM Mahlzeiten
                        LEFT JOIN MahlzeitenHabenBilder MHB on Mahlzeiten.ID = MHB.ID_M
                        LEFT JOIN Bilder B on MHB.ID_B = B.ID
                        WHERE Mahlzeiten.ID = $value";
                        $result1 = mysqli_query($remoteConnection, $query1);
                        $row1 = mysqli_fetch_assoc($result1);
                        if($row['Verfügbar'])
                        {
                            echo '<div class="col ">
                                    <div class="col "><img class="img details_picture mw-100" alt="platzhalter" src="data:image/jpeg;base64,' . base64_encode($row1['Binärdaten']) . '"></div>
                                     <div class="col "><a>' . $row['Name'] . '</a></div>
                                     <div class="col "><a class="fh_color" href="Detail.php?id=' . $row['ID'] . '"> Details</a></div>
                                    </div>';
                        }
                        else
                        {
                           echo '<div class="col  passdout">
                                     <div class="col"><img class="img details_picture mw-100" alt="platzhalter" src="data:image/jpeg;base64,' . base64_encode($row1['Binärdaten']) . '"></div>
                                     <div class="col"><a>' . $row['Name'] . '</a></div>
                                     <div class="col "><a class="fh_color" > Details</a></div>
                                     </div>';
                        }
                    }
                }
        echo '</div>';

   }

    echo '</div>
    </div>
</div>'
?>
<?php
mysqli_close($remoteConnection);
include ('snippets/navbarunten.php')
?>
</body>
</html>