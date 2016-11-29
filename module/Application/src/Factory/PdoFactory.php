<?php
namespace Application\Factory;
/**
 * Created by PhpStorm.
 * User: benmorris
 * Date: 29/11/2016
 * Time: 11:40
 */
class PdoFactory
{
    public function __invoke()
    {
        $servername = "192.168.20.56";
        $dbname = "survey_app";
        $username = "root";
        $password = "";
        return new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }
}