<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Zutaten.php</title>
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
<?php

?>

<div class="container">
    <div class="row mt-4">
        <div class="col-12 float-md-none">
            <?php
            $query = 'SELECT COUNT(ID) as count FROM Zutaten;';
            $result = mysqli_query($remoteConnection, $query);
            $count= mysqli_fetch_assoc($result);
            echo '('.$count['count'].')'.'<a>'.'Zutaten'.'</a>';
            ?>
        </div>
    </div>
    <div class="border-dark border">
        <table class="table table-striped table-hover">
            <?php
            $query = 'SELECT Name,Bio,Vegetarisch,Vegan,Glutenfrei FROM Zutaten ORDER BY bio DESC ,Name ASC ;'; // Ihre SQL Query aus HeidiSQL

            if ($result = mysqli_query($remoteConnection, $query))
            {
                echo'<thead>';
                echo'<tr class="">';
                echo'<th scope="col" class="w-auto">'.'<a class="m-2">'.'Zutaten'.'</a>'.'</th>';
                echo'<th scope="col" class="w-auto">'.'<a class="m-2">'.'Bio?'.'</a>'.'</th>';
                echo'<th scope="col" class="w-auto">'.'<a class="m-2">'.'Vegan?'.'</a>'.'</th>';
                echo'<th scope="col" class="w-auto">'.'<a class="m-2">'.'Vegetarisch?'.'</a>'.'</th>';
                echo'<th scope="col" class="w-auto">'.'<a class="m-2">'.'Glutenfrei?'.'</a>'.'</th>';
                echo'</tr>';
                echo'</thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo'<tr>';

                    echo '<td>'.$row['Name'].'</td>';
                   if( $row['Bio']){echo '<td>'.'<img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg">'.'</td>';}else {echo '<td>'.'<img class="img symbol float-md-left ml-2" src="button/svgs/regular/circle.svg">'.'</td>';}
                   if( $row['Vegan']){echo '<td>'.'<img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg">'.'</td>';}else {echo '<td>'.'<img class="img symbol float-md-left ml-2" src="button/svgs/regular/circle.svg">'.'</td>';}
                   if( $row['Vegetarisch']){echo '<td>'.'<img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg">'.'</td>';}else {echo '<td>'.'<img class="img symbol float-md-left ml-2" src="button/svgs/regular/circle.svg">'.'</td>';}
                   if( $row['Glutenfrei']){echo '<td>'.'<img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg">'.'</td>';}else {echo '<td>'.'<img class="img symbol float-md-left ml-2 regular" src="button/svgs/regular/circle.svg">'.'</td>';}

                   echo '</tr>';
                }
                echo '</tbody>';
            }
            mysqli_close($remoteConnection);
            ?>

        </table>
    </div>
</div>




<?php
include ('snippets/navbarunten.php')
?>

</body>
</html>