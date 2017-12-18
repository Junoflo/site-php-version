<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/12/11
 * Time: 11:45
 */

    include "BaseData.php";
    header("content-type:text/html;charset=utf-8");
    class UserData extends BaseData {

        private static $conn;
        public function __construct(){
            self::$conn = parent::getConn();
        }

        public function get_count(){
            $sql = "select count(*) as res from site.user";
            $result = self::$conn->query($sql);
            if ($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    echo "总共有 ".$row["res"] . " 个用户...";
                }
            }
        }
    }
    $test = new UserData();
    $test::get_count();