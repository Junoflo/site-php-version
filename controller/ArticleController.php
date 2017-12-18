<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/12/11
 * Time: 12:02
 */
    include "../model/ArticleData.php";
    class ArticlePage{
        public $code = "";
        public $msg = "";
        public $count = "";
        public $data = [];
    }
    function get_count(){
        $test = new ArticleData();
        $test::article_count();
    }
    function get_all(){
        if (isset($_GET["page"]) && isset($_GET["limit"])){
            $page = $_GET["page"];
            $size = $_GET["limit"];
        }
        $test = new ArticleData();
        if (isset($page) && isset($size)){
            $articles = $test::article_all_page($page, $size);
            $res = new ArticlePage();
            $res -> count = $test::article_count();
            $res -> data = $articles;
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            return false;
        }
        $test::article_all();
    }
    function add_article(){
        $article = new Article();
        $article -> title = $_POST["title"];
        $article -> type = $_POST["type"];
        $article -> author = $_POST["author"];
        $article -> content = $_POST["content"];
        $test = new ArticleData();
        $res = $test -> article_add($article);
        echo json_encode($res);
    }
    function get_one(){
        if (isset($_GET)){
            $id = $_GET["id"];
            $test = new ArticleData();
            $test -> article($id);
        }
    }
    function lock_one(){
        if (isset($_POST["id"])){
            $id = $_POST["id"];
            $test = new ArticleData();
            $locked = $test -> article_lock($id);
            echo json_encode($locked);
        }
    }
    function delete_one(){
        if (isset($_POST["id"])){
            $id = $_POST["id"];
            $test = new ArticleData();
            $deleted = $test -> article_delete($id);
            echo json_encode($deleted);
        }
    }
    function get_brief(){
        $test = new ArticleData();
        $test -> article_brief();
    }

    $action = "";
    if (isset($_GET["action"])){
        $action = $_GET["action"];
    }
    if (isset($_POST["action"])){
        $action = $_POST["action"];
    }
    switch ($action){
        case "get_count" : get_count();break;
        case "get_all" : get_all();break;
        case "add_article" : add_article();break;
        case "get_brief" : get_brief();break;
        case "get_one" : get_one();break;
        case "lock_one" : lock_one();break;
        case "delete_one" : delete_one();break;
        default : break;
    }