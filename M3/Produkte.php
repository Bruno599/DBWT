<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkte.php</title>
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

if(isset($_POST["avail"]))
{
    $limit1 = $_POST["limit"];
}else{
    $limit1 = 4;
}
;

//$avail = $_POST["avail"];
if(isset($_POST["avail"])) {
    if($_POST["limit"] > 0) {
        $query="select ID, Name, Verfügbar FROM Mahlzeiten WHERE Verfügbar = true LIMIT $limit1";
    }
    else {
            $query="select ID, Name, Verfügbar FROM Mahlzeiten WHERE Verfügbar = true";
        }
}
else {
    if($_POST["limit"] > 0) {
        $query="select ID, Name, Verfügbar FROM Mahlzeiten LIMIT $limit1";
    }
    else {
        $query="select ID, Name, Verfügbar FROM Mahlzeiten";
    }
}

$avail = "Verfügbar = true";
$limit2 = "";


$result = mysqli_query($remoteConnection, $query);

$query2 ="select Kategorien.ID, Kategorien.Bezeichnung, Kategorien.hatKategorie FROM Kategorien ORDER BY Kategorien.hatKategorie ASC";

$result2 = mysqli_query($remoteConnection, $query2);

while ($row2 = mysqli_fetch_assoc($result2))
{
    $array[] = $row2;
}
/*foreach ($array as $arra)
{
    echo $arra['Bezeichnung'];
    echo $arra['hatKategorie'];
}
*/

echo
'<div class="container ">
    <div class="row m-4">
        <div class="col-2 ml-3">
        </div>
        <div class="col text-left ">
            <h2>Verfügbare Speisen (Bestseller)</h2>
        </div>
    </div>
    <div class="row m-2">
        <div class="col-2 border m-2 border-dark" id="speise_filtern">
           <form method="post">
               <fieldset>
                   <legend class="text-nowrap text-hide">Speisenliste filter</legend>
                   <p class="on_line text-center">Speisenliste filter</p>
                   <select class="w-100 mb-5 mt-5" name="kategorien">
                   <option>Alle zeigen</option>';
                    foreach ($array as $element) {
                        if($element['hatKategorie'] == NULL) {
                            echo '<optgroup label="'.$element['Bezeichnung'].'">';
                            foreach ($array as $element2) {
                                if ($element['ID'] == $element2['hatKategorie']) {
                                    if($_POST['kategorien'] == $element2['Bezeichnung']) {
                                        echo '<option selected>'.$element2['Bezeichnung'].'</option>';
                                    } else {
                                        echo '<option>'.$element2['Bezeichnung'].'</option>';
                                    }

                                }
                            }
                            echo '</optgroup>';
                        }
                    }

                       /* while ($row2 = mysqli_fetch_assoc($result2))
                        {
                            echo $row2['hatKategorie'];
                            while($row2['hatKategorie'] == 1)
                            {
                                $ID = $row2['ID'];
                                echo '<optgroup label="'.$row2['Beschreibung'].'">';
                                while ($row3 = mysqli_fetch_assoc($result2))
                                {
                                    if($row3['hatKategorie'] = $ID)
                                    {
                                        echo '<option>'.$row2['Beschreibung'].'</option>';
                                    }
                                }
                                echo '</optgroup>';
                            }
                        }
*/


                   echo '</select>';
                   if(isset($_POST["avail"])){
                       echo '<input type="checkbox" class="m-2" name="avail" checked> nur verfügbar';
                   } else {
                       echo '<input type="checkbox" class="m-2" name="avail" > nur verfügbar';
                   }

                   if(isset($_POST['vegetarisch'])){
                       echo '<input type="checkbox" class="m-2" name="vegetarisch" checked> nur vegetarisch';
                   } else {
                       echo '<input type="checkbox" class="m-2" name="vegetarisch"> nur vegetarisch';
                   }

                   if(isset($_POST['vegan'])){
                       echo '<input type="checkbox" class="m-2" name="vegan" checked> nur vegan';
                   } else {
                       echo '<input type="checkbox" class="m-2" name="vegan"> nur vegan';
                   }


                   echo '<input type="hidden" name="limit" value="4">

                   <button type="submit" class="mt-5">Speisen filtern</button>
               </fieldset>
           </form>
        </div>
      
        <div class="col" id="body_produkte">';


//for($j = 0;$j <= 2;$j++)
    //{

        echo '<div class="row text-center">';
            //for($i = 0;$i <4;$i++)
                //{
                    while ($row = mysqli_fetch_assoc($result)) {

                        $value = $row['ID'];
                        $query1 = "SELECT Mahlzeiten.ID, B.Binärdaten FROM Mahlzeiten
                        LEFT JOIN MahlzeitenHabenBilder MHB on Mahlzeiten.ID = MHB.ID_M
                        LEFT JOIN Bilder B on MHB.ID_B = B.ID
                        WHERE Mahlzeiten.ID = $value";
                        $result1 = mysqli_query($remoteConnection, $query1);
                        $row1 = mysqli_fetch_assoc($result1);
                        if($row['Verfügbar'])
                        {
                            echo '<div class="col-3 mb-2 mt-2 p-0">
                                    <div class="col "><img class="img mw-100 preview" alt="platzhalter" src="data:image/jpeg;base64,' . base64_encode($row1['Binärdaten']) . '"></div>
                                     <div class="col "><a>' . $row['Name'] . '</a></div>
                                     <div class="col "><a class="fh_color" href="Detail.php?id=' . $row['ID'] . '"> Details</a></div>
                                    </div>';
                        }
                        else
                        {
                           echo '<div class="col-3 mb-2 mt-2 p-0 passdout">
                                     <div class="col"><img class="img mw-100 preview" alt="platzhalter" src="data:image/jpeg;base64,' . base64_encode($row1['Binärdaten']) . '"></div>
                                     <div class="col"><a>' . $row['Name'] . '</a></div>
                                     <div class="col "><a class="fh_color" > Vergriffen</a></div>
                                     </div>';
                        }
                    }
                //}
        echo '</div>';

   //}

    echo '</div>
    </div>
</div>'
?>
<?php
include ('snippets/navbarunten.php');
mysqli_close($remoteConnection);
?>
</body>
</html>