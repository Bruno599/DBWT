<?php

require __DIR__ . '/../vendor/autoload.php';

class DatabaseConnector
{
    public function connectToDatabase($config)
    {
        $dotenv = Dotenv\Dotenv::create(__DIR__, $config);
        $dotenv->overload();
        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT']);

        $remoteConnection = mysqli_connect(
            getenv('DB_HOST'),
            getenv('DB_USER'),
            getenv('DB_PASS'),
            getenv('DB_NAME'),
            (int)getenv('DB_PORT')
        );

        if (!$remoteConnection) {
            echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
            exit();
        }

        return $remoteConnection;
    }

    public function disconnectFromDatabase($remoteConnection)
    {
        mysqli_close($remoteConnection);
    }
}