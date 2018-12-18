<?php 
    set_include_path("src");
    require("src/init.php");
    session_start();

    $isLogin = !empty($_SESSION["USERID"]);

    function ShowAllComments (PDO &$pdo) {
        $sql = "SELECT * FROM comments ORDER BY id;";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $results = $stmt->fetchAll();
            echo "<table border=\"0\"";
            foreach ($results as $row) {
                PrintOneComment ($pdo, $row);
            }    
            echo "</table>";
        }
    }
    function PrintOneComment(PDO &$pdo, $res) {
        $name = GetName($pdo, $res["account_id"]);
        echo "<tr>";
        echo "<td>{$res["id"]}</td>";
        echo "<td>{$name}</td>";
        echo "<td>{$res["time"]}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td>{$res["comment"]}</td>";
        echo "<td></td>";
        echo "</tr>";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
<center>
<h1>たけしのウェブ掲示板</h1>
    <?php 
        if ($isLogin) {
            echo "<div>ようこそ、{$_SESSION["USERNAME"]}さま</div>";
        }
        else {
            echo '<a href="./login.php">Log in</a> <a href="./create_account.php">Sign Up</a>';
        }
    ?>
    <hr>
    <textarea form="post" name="comment" id="comment" cols="30" rows="10" placeholder="コメントを入力" ></textarea>
    <form action="" method='post' id="post">
        <!-- <input type="text" name="name" placeholder="名前" 
        value=<?php
            // if (!empty($_POST["edit"]) && CheckPassword($pdo, $_POST["edit"], $_POST["password"])) {
            //     $name = GetName($pdo, $_POST["edit"]);
            //     echo $name;
            // }
        ?>><br>
        <input type="text" name="comment" placeholder="コメント"
        value=<?php
            // if (!empty($_POST["edit"]) && CheckPassword($pdo, $_POST["edit"], $_POST["password"])) {
            //     $comment = GetComment($pdo, $_POST["edit"]);
            //     echo $comment;
            // }
        ?>><br> -->
        <!-- <input type="text" name="password" placeholder="パスワード"><br>
        <?php
            // if (!empty($_POST["edit"]) && CheckPassword($pdo, $_POST["edit"], $_POST["password"])) {
            //     echo "<input type=\"hidden\" name=\"editNo\" value=\"{$_POST["edit"]}\">";
            // }
        ?> -->
        <input type="submit" value="送信" name="commentBtn"><br><br>
    </form>

    <form action="" method="post">
        <input type="text" name="delete_no" placeholder="削除対象番号"><br>
        <input type="password" name="password" placeholder="パスワード"><br>
        <input type="submit" value="削除" name="deleteBtn"><br>
    </form>
    
    <form action="" method="post">
        <input type="text" name="edit" placeholder="編集対象番号"><br>
        <input type="password" name="password" placeholder="パスワード"><br>
        <input type="submit" value="編集" name="editBtn"><br>
    </form>
    <hr>
    <?php
        if (isset($_POST["commentBtn"])) {
            if (!empty($_POST["comment"]))
                InsertComment($pdo, $_SESSION["USERID"], $_POST["comment"]);
            else {
                echo "コメントを入力してください";
            }
        }

        if (isset($_POST["deleteBtn"])) {
            if (!empty($_POST["delete_no"]) && is_numeric($_POST["delete_no"]) && !empty($_POST["password"])) {
                if (CheckPasswordByID($pdo, $_SESSION["USERID"], $_POST["password"])) {
                    if (CheckCommentOwner($pdo, $_SESSION["USERID"], $_POST["delete_no"])) {
                        DeleteComment($pdo, $_POST["delete_no"]);
                    }
                }
            }
        }

        ShowAllComments($pdo);
    ?>
    </center>
</body>
</html>