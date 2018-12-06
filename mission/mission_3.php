<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    </head>
</html>
<?php
    function ShowResult (&$pdo) {
        $sql = "SELECT * FROM tbtest;";
        $stmt = $pdo -> query($sql);
        $results = $stmt->fetchAll();
    
        foreach ($results as $row) {
            echo "{$row['id']}, {$row['name']}, {$row['comment']}<br>";
        }    
        echo "<hr>";
    }

    $host = 'tt-345.99sv-coco.com';
    $db_name = 'tt_345_99sv_coco_com';
    $dsn = "mysql:dbname={$db_name};host=localhost";
    $user = "tt-345.99sv-coco";
    $password = "k2NvCDuU";
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $sql = "DROP TABLE tbtest;";
    $pdo->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS tbtest (id INT, name char(32), comment TEXT, PRIMARY KEY(id));";
    $stmt = $pdo->query($sql);

    echo "INSERT<br>";
    $sql = "INSERT INTO tbtest (id, name, comment) VALUES (1, 'takeshi', 'hello world')";
    $pdo->query($sql);
    $sql = "INSERT INTO tbtest (id, name, comment) VALUES (2, 'キリト', 'スターバーストストリーム')";
    $pdo->query($sql);

    ShowResult ($pdo);

    $id = 1;
    $name = "takahashi";
    $comment = "change name";
    $sql = "UPDATE tbtest SET name=:name, comment=:comment WHERE id=:id;";

    $stmt = $pdo->prepare ($sql);
    $stmt->bindParam (":name", $name, PDO::PARAM_STR);
    $stmt->bindParam (":comment", $comment, PDO::PARAM_STR);
    $stmt->bindParam (":id", $id, PDO::PARAM_INT);
    echo "{$stmt->queryString}<br>";
    $stmt->execute();

    ShowResult($pdo);

    $id = 1;
    $sql = "DELETE FROM tbtest WHERE id=:id";
    $stmt = $pdo->prepare ($sql);
    $stmt->bindParam (":id", $id, PDO::PARAM_INT);
    echo "{$stmt->queryString}<br>";
    $stmt->execute();

    ShowResult($pdo);
?>