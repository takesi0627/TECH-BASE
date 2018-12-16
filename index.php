<!DOCTYPE html>
<html>
<?php 
    set_include_path("src");
    require("src/init.php");
?>
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
    </center>
    <hr>
</body>
</html>