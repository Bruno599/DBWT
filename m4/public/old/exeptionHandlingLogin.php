<?php
class exeptionHandlingLogin_passwort extends Exception
{
    public function errorMessage(){

        $errorMSG = $this->getMessage();
        return $errorMSG;
    }


}