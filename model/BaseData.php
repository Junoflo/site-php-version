<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/12/11
 * Time: 10:59
 */
include "config.php";
class BaseData{

    private static $conn;
    static function getConn(){
        if (isset(self::$conn)){
            echo "base data ... isset = true<br>";
            $program_char = "utf8" ;
            mysqli_set_charset(self::$conn, $program_char);
            return self::$conn;
        }
        $dbData = config::getAll("../model/dbconfig");
        $serverName = $dbData["host"];
        $username = $dbData["username"];
        $password = $dbData["password"];
        self::$conn = new mysqli($serverName, $username, $password);
        return self::$conn;
    }

}
