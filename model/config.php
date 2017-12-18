<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/12/7
 * Time: 17:40
 */
    class config{
        static public $conf = [];
        static public function getFirst($name, $file){
            if (isset(self::$conf[$file])){
                return self::$conf[$file][$name];
            }
            $path = $file.'.php';
            if (file_exists($path)){
                $conf = include_once $path;
                if (isset($conf[$name])){
                    self::$conf[$file] = $conf;
                    return $conf[$name];
                }
                throw new \Exception("文件配置不存在...".$name);
            }
            throw new \Exception("文件不存在...".$file);
        }
        static public function getAll($file){
            if (isset($conf)){
                return self::$conf[$file];
            }
            $path = $file.".php";
            if (file_exists($path)){
                $conf = include_once $path;
                self::$conf[$file] = $conf;
                return $conf;
            }
            throw new Exception("文件不存在:【".$file."】");
        }
    }

   // $c = new config();
  //  $c::getAll("dbconfig");
  //  $c::getFirst("host","dbconfig");