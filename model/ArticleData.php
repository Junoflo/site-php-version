<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/12/11
 * Time: 11:08
 */
include "BaseData.php";
include "Article.php";
class ArticleData extends BaseData {

    private static $conn = "";
    function __construct(){
        self::$conn = parent::getConn();
    }

    public function article_count(){
        $sql = "select count(*) as res from site.article";
        $result = self::$conn->query($sql);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                return $row["res"];
            }
        }
    }

    public function fetch_article($result){
        $articles = [];
        while ($row = $result->fetch_assoc()){
            $article = new Article();
            $article -> id = $row["id"];
            $article -> title = $row["title"];
            $article -> author = $row["author"];
            $article -> type = $row["type"];
            //  $article -> content = $row["content"];
            $article -> created = date('Y-m-d H:i', $row["created"]);
            $article -> status = $row["status"]  == 1 ? '激活' : '不可用';
            array_push($articles, $article);
        }
        return $articles;
    }

    public function article_all(){
        $sql = "SELECT * FROM site.article";
        $result = self::$conn->query($sql);
        if ($result->num_rows > 0){
            $articles = self::fetch_article($result);
            echo json_encode($articles, JSON_UNESCAPED_UNICODE);
        }
    }

    public function article_all_page($page, $size){
        $start = ($page - 1) * $size;
        $end = $start + $size;
        $sql = "SELECT * FROM site.article LIMIT ".$start.",".$end;
        $result = self::$conn -> query($sql);
        if ($result -> num_rows > 0){
            $articles = self::fetch_article($result);
            return $articles;
        }
    }

    public function article_add(Article $article){
        $sql = "insert into site.article(title,author,type,content,created,status) values('".$article->title.
            "','".$article->author."','".$article->type."','".$article->content."',".time().",1)";
        self::$conn->query($sql);
        return mysqli_insert_id(self::$conn) > 0;
    }

    public function article_lock($id){
        $sql = "UPDATE site.article SET status = 0 WHERE id = ".$id;
        self::$conn->query($sql);
        $sql = "SELECT status FROM site.article WHERE id = ".$id;
        $deleted = self::$conn -> query($sql);
        if ($deleted -> num_rows > 0){
            while($row = $deleted -> fetch_assoc()){
                return $row["status"] == 0;
            }
        }
    }

    public function article_delete($id){
        $sql = "DELETE FROM site.article WHERE id = ".$id;
        self::$conn->query($sql);
        $sql = "SELECT count(id) as res FROM site.article WHERE id = ".$id;
        $deleted = self::$conn -> query($sql);
        if ($deleted -> num_rows > 0){
            while($row = $deleted -> fetch_assoc()){
                return $row["res"] == 0;
            }
        }
    }

    public function article_brief(){
        $sql = "SELECT id, title, author FROM site.article";
        $result = self::$conn->query($sql);
        $articles = [];
        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                $a = new Article();
                $a->id = $row["id"];
                $a->title = $row["title"];
                $a->author = $row["author"];
                array_push($articles, $a);
            }
            echo json_encode($articles, JSON_UNESCAPED_UNICODE);
        }
    }

    public function article($id){
        $sql = "SELECT * FROM site.article WHERE id = ".$id;
        $result = self::$conn->query($sql);
        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                $a = new Article();
                $a->id = $row["id"];
                $a->title = $row["title"];
                $a->author = $row["author"];
                $a->created = $row["created"];
                $a->content = $row["content"];
                echo json_encode($a, JSON_UNESCAPED_UNICODE);
            }
        }
    }

}

