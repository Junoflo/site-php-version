<?php
    include "config.php";
    $dbData = config::getAll("dbconfig");
    $serverName = $dbData["host"];
    $username = $dbData["username"];
    $password = $dbData["password"];
    $conn = new mysqli($serverName, $username, $password);

    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    class User{
        public $id = "";
        public $username = "";
        public $password = "";
        public $nickname = "";
        public $type = "";
        public $status = "";
    }
    $sql = "SELECT * FROM site.user";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $u = new User();
            $u -> id = $row["id"];
            $u -> username = $row["user_name"];
            $u -> password = $row["password"];
            $u -> nickname = $row["nick_name"];
            $u -> type = $row["type"];
            $u -> status = $row["status"];
            array_push($users, $u);
        }
        echo json_encode($users);
    } else {
        echo "0 结果";
    }
    $conn->close();
