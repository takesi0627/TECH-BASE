<!DOCTYPE html>
<html>
<?php
    $page_path = "mission_4.php";
    $db_name = 'db_name';
    $user = "user_name";
    $password = "password";

    $login_info = file("login_info");
    for ($i=0; $i < count($login_info); $i++) { 
        $tokens = explode("=", $login_info[$i]);
        if ($i == 0) 
            $db_name = trim($tokens[1]);
        elseif ($i == 1)
            $user = trim($tokens[1]);
        elseif ($i == 2)
            $password = trim($tokens[1]);
    }

    define ("TABLE_NAME", "tbtest");

    $pdo = ConnectDB($db_name, $user, $password);
    // DropTable($pdo, TABLE_NAME);
    CreateDB($pdo);
?>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>たけしのWEB掲示板</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <form action=<?php echo $page_path;?> method='post'>
        <input type="text" name="name" placeholder="名前" 
        value=<?php
            if (!empty($_POST["edit"]) && CheckPassword($pdo, $_POST["edit"], $_POST["password"])) {
                $name = GetName($pdo, $_POST["edit"]);
                echo $name;
            }
        ?>><br>
        <input type="text" name="comment" placeholder="コメント"
        value=<?php
            if (!empty($_POST["edit"]) && CheckPassword($pdo, $_POST["edit"], $_POST["password"])) {
                $comment = GetComment($pdo, $_POST["edit"]);
                echo $comment;
            }
        ?>><br>
        <input type="text" name="password" placeholder="パスワード"><br>
        <?php
            if (!empty($_POST["edit"]) && CheckPassword($pdo, $_POST["edit"], $_POST["password"])) {
                echo "<input type=\"hidden\" name=\"editNo\" value=\"{$_POST["edit"]}\">";
            }
        ?>
        <input type="submit" value="送信"><br><br>
    </form>

    <form action=<?php echo $page_path;?> method="post">
        <input type="text" name="delete" placeholder="削除対象番号"><br>
        <input type="text" name="password" placeholder="パスワード"><br>
        <input type="submit" value="削除"><br>
    </form>
    
    <form action=<?php echo $page_path;?> method="post">
        <input type="text" name="edit" placeholder="編集対象番号"><br>
        <input type="text" name="password" placeholder="パスワード"><br>
        <input type="submit" value="編集"><br>
    </form>
    <?php

        if (!empty($_POST["editNo"])) {
            Update($pdo, $_POST["editNo"], $_POST["name"], $_POST["comment"]);
        }
        else if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])) {
            $no = GetLastNumber($pdo) + 1;
            Insert($pdo, $no, $_POST["name"], $_POST["comment"], $_POST["password"]);
        }
        
        if (!empty($_POST["delete"]) && !empty($_POST["password"]) && CheckPassword($pdo, $_POST["delete"], $_POST["password"])) {
            Delete($pdo, $_POST["delete"]);
        }


        echo "<hr>";
        ShowResult($pdo);
    ?>
</body>
</html>


<?php
/**
 * sql functions
 */
    function ConnectDB ($db_name, $user, $password){
        $dsn = "mysql:dbname={$db_name};host=localhost";
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        return $pdo;    
    }

    function DropTable (PDO &$pdo, $table) {
        $sql = "DROP TABLE tbtest;";
        $stmt = $pdo->query($sql);
        // $stmt->bindParam(":table", $table, PDO::PARAM_STR);
        // $stmt->execute();
    }

    function CreateDB (PDO &$pdo) {
        $sql = "CREATE TABLE IF NOT EXISTS tbtest (".
            "id INT,". 
            "name char(32),".
            "comment TEXT,".
            "password char(32),".
            "time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,". // データ入力するとき自動的に時間を入れる
            "PRIMARY KEY(id)".
            ");";
        $stmt = $pdo->query($sql);
    }

    function ShowResult (PDO &$pdo) {
        $sql = "SELECT * FROM tbtest ORDER BY id;";
        $stmt = $pdo -> query($sql);
        $results = $stmt->fetchAll();
    
        foreach ($results as $row) {
            echo "{$row['id']} {$row['name']} {$row['time']}　{$row['comment']}<br>";
        }    
    }

    function Insert(PDO &$pdo, $id, $name, $comment, $password) {
        $sql = "INSERT INTO tbtest (id, name, comment, password) VALUES (:id, :name, :comment, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam (":id", $id, PDO::PARAM_INT);
        $stmt->bindParam (":name", $name, PDO::PARAM_STR);
        $stmt->bindParam (":comment", $comment, PDO::PARAM_STR);
        $stmt->bindParam (":password", $password, PDO::PARAM_STR);
        $stmt->execute ();
    }

    function Delete (PDO &$pdo, $id) {
        $sql = "DELETE FROM tbtest WHERE id=:id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    function Update (PDO &$pdo, $id, $new_name, $new_comment) {
        $sql = "UPDATE tbtest SET name=:name, comment=:comment WHERE id=:id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":name", $new_name, PDO::PARAM_STR);
        $stmt->bindParam(":comment", $new_comment, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    function GetLastNumber (PDO &$pdo) {
        $sql = "SELECT id FROM tbtest ORDER BY id;";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();

        if (count($results) > 0) {
            $last = end($results);
            return $last['id'];
        } 
        else {
            return 0;
        }
    }

    function GetComment (PDO &$pdo, $id) {
        $sql = "SELECT comment FROM tbtest WHERE id=:id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchColumn();
        return $res;        
    }

    function GetName (PDO &$pdo, $id) {
        $sql = "SELECT name FROM tbtest WHERE id=:id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchColumn();
        return $res;
    }

    function CheckPassword (PDO &$pdo, $id, $password) {
        $sql = "SELECT id, password FROM tbtest WHERE id=:id AND password=:password;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetchAll();
        if (count($res) == 1) 
            return true;
        else 
            return false;
    }
?>