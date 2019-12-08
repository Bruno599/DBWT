<?php
namespace Emensa\Model
{
    require_once "snippets/DatabaseConnector.php";
    class zutatenModel
    {

        public $zutatenliste = array();
        public $zutatenanzahl;

        public function zutaten(){
            $database = new \DatabaseConnector();
            $connection = $database->connectToDatabase("/../connection.env");

            $query = "SELECT Name,Bio,Vegetarisch,Vegan,Glutenfrei FROM Zutaten ORDER BY bio DESC ,Name ASC";
            $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result)){
                //$zutaten[] = $row;
                array_push($this->zutatenliste, array("Name" => $row['Name'], "Bio" => $row['Bio'],
                    "Vegetarisch" => $row['Vegetarisch'], "Vegan" => $row['Vegan'], "Glutenfrei" => $row['Glutenfrei']));
            }


            $this->zutatenanzahl = mysqli_num_rows($result);

            $database->disconnectFromDatabase($connection);
            return $this->zutatenliste;
        }
    }
}