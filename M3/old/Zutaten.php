<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Zutaten.php</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
    <?php
    include('snippets/mysqlconnect.php')
    ?>
</head>
<body>
<?php
include('snippets/navbaroben.php')
?>


<div class="container mt-4">
    <div class="row mt-2">
        <div class="col-12 float-md-none">
            <?php
            $query = 'SELECT COUNT(ID) as count FROM Zutaten;';
            $result = mysqli_query($remoteConnection, $query);
            $count= mysqli_fetch_assoc($result);
            echo '<a><h2>'.'('.$count['count'].')'.' Zutaten</h2></a>';
            ?>
        </div>
    </div>
    <div class="border-dark border mt-4">
        <table class="table table-striped table-hover">
            <?php

            $query = 'SELECT Name,Bio,Vegetarisch,Vegan,Glutenfrei FROM Zutaten ORDER BY bio DESC ,Name ASC'; // Ihre SQL Query aus HeidiSQL

            if ($result = mysqli_query($remoteConnection, $query))
            {
                echo'<thead>';
                echo'<tr class="">';
                echo'<th scope="col" class="w-auto">'.'<a class="m-1">'.'Zutaten'.'</a>'.'</th>';
                echo'<th scope="col" class="w-auto">'.'<a class="m-1">'.'Bio?'.'</a>'.'</th>';
                echo'<th scope="col" class="w-auto">'.'<a class="m-1">'.'Vegan?'.'</a>'.'</th>';
                echo'<th scope="col" class="w-auto">'.'<a class="m-1">'.'Vegetarisch?'.'</a>'.'</th>';
                echo'<th scope="col" class="w-auto">'.'<a class="m-1">'.'Glutenfrei?'.'</a>'.'</th>';
                echo'</tr>';
                echo'</thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo'<tr>';

                    echo    '<td>
                            <form action="http://www.google.de/search" target="_blank" method="get">
                            <input class="btn btn-link" type="submit" name="q"  value="'.htmlspecialchars($row['Name']).'" data-toggle="tooltip" title="Suchen Sie nach '.htmlspecialchars($row['Name']).' im Web">
                            </form>
                            </td>';
                   if( $row['Bio']){echo '<td><img class="img symbol float-md-left ml-2" src="../button/svgs/regular/check-circle.svg" alt="fehler"></td>';}else {echo '<td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/circle.svg" alt="fehler"></td>';}
                   if( $row['Vegan']){echo '<td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg" alt="fehler"></td>';}else {echo '<td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/circle.svg" alt="fehler"></td>';}
                   if( $row['Vegetarisch']){echo '<td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg" alt="fehler"></td>';}else {echo '<td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/circle.svg" alt="fehler"></td>';}
                   if( $row['Glutenfrei']){echo '<td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg" alt="fehler"></td>';}else {echo '<td><img class="img symbol float-md-left ml-2 regular" src="button/svgs/regular/circle.svg" alt="fehler"></td>';}

                   echo '</tr>';
                }
                echo '</tbody>';
            }
            //mysqli_close($remoteConnection);
            ?>

        </table>
    </div>
</div>




<?php
mysqli_close($remoteConnection);
include ('snippets/navbarunten.php')
?>

</body>
</html>