<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <title>MISSION 2</title>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
    <!-- <script src="main.js"></script> -->
</head>
<body>
    <?php 
        $page_path = "mission_2-5.php";
        $file_name = "mission_2-5_history.txt";
        $contents = array();
        if (file_exists($file_name)) {
            $contents = file($file_name);
        }

        function CheckPwd($contents, $id, $pwd)
        {
            $token = GetToken($contents, $id);
            return trim($token[4]) == $pwd;
        }

        function GetToken ($contents, $id) 
        {
            foreach ($contents as $str) {
                $token = explode("<>", $str);
                if ($token[0] == $id) {
                    return $token;
                }
            }
        }
    ?>
    <center>
        <h1>WEB掲示板</h1>
        <form action=<?php echo $page_path; ?> method='post'>
            <input type="text" name="name" placeholder="名前"
            <?php 
                if (isset($_POST["edit"]) && CheckPwd($contents, $_POST["edit"], $_POST["pwd"])) {
                    foreach ($contents as $str) {
                        $token = explode("<>", $str);
                        if ($token[0] == $_POST["edit"]) {
                            echo "value=\"{$token[1]}\"";
                        }
                    }
                }
            ?>/><br>
            <input type="text" name="comment" placeholder="コメント"
            <?php
                if (isset($_POST["edit"]) && CheckPwd($contents, $_POST["edit"], $_POST["pwd"])) {
                    $token = GetToken($contents, $_POST["edit"]);
                    echo "value=\"{$token[2]}\"";
                }
            ?>
            /><br>
            <?php
                if (empty($_POST["edit"]) || 
                    (isset($_POST["edit"]) && !CheckPwd($contents, $_POST["edit"], $_POST["pwd"]))){
                    echo "<input type=\"text\" name=\"pwd\" placeholder=\"パスワード\"/><br>";
                }
                else {
                    echo "<input type=\"hidden\" name=\"pwd\" value=\"{$_POST["pwd"]}\"/>";
                    echo "<input type=\"hidden\" name=\"edit_no\" value=\"{$_POST["edit"]}\"/><br>";
                }
            ?>
            <input type="submit" value="送信"/><br>
        </form>
        <br>
        <form action=<?php echo $page_path; ?> method='post'>
            <input type="text" name="delete" placeholder="削除対象番号"/>
            <input type="text" name="pwd" placeholder="パスワード"/><br>
            <input type="submit" value="削除"/><br>
        </form>
        <form action=<?php echo $page_path; ?> method='post'>
            <input type="text" name="edit" placeholder="編集対象番号"/>
            <input type="text" name="pwd" placeholder="パスワード"/><br>
            <input type="submit" value="編集"/><br>
        </form>
        <hr>
    </center>

    <?php
        if (isset($_POST["edit"]) && !CheckPwd($contents, $_POST["edit"], $_POST["pwd"])) {
            echo "パスワードが間違っています。確認してください。<br><hr>";
        }
        if (isset($_POST["comment"])){
            if (strcmp($_POST['comment'], "") !== 0) {
                $time = date("Y-m-d H:i:s");
                $comment = $_POST["comment"];
                $name = $_POST["name"];
                $password = $_POST["pwd"];

                if (isset($_POST["edit_no"])) {
                    $number = $_POST["edit_no"];
                    $new_content = "{$number}<>{$name}<>{$comment}<>{$time}<>{$password}";
                    
                    $fp = fopen($file_name, 'w');
                    foreach ($contents as &$str) {
                        $token = explode("<>", $str);
                        if ($token[0] == $number) {
                            $str = $new_content;
                        }
                        fwrite ($fp, trim($str)."\n");
                    }
                    fclose($fp);
                    unset($str); 
                }
                else {
                    if (empty($_POST["pwd"])){
                        echo "パスワードを入力してください。<br><hr>";
                    }
                    else {
                        // get the last number of the comment in the file and plus 1
                        $last_token = explode("<>", end($contents));
                        $number = $last_token[0] + 1;
                        
                        $new_content = "{$number}<>{$name}<>{$comment}<>{$time}<>{$password}";
                        array_push($contents, $new_content);

                        $fp = fopen($file_name, 'a');
                        fwrite($fp, "{$new_content}\n");
                        fclose($fp);
                    }
                }
            }
            else {
                echo "コメントは空欄です。<br><hr>";
            }
        }

        if (isset($_POST["delete"])) {
            $pwd = $_POST["pwd"];
            if (CheckPwd($contents, $_POST["delete"], $pwd)){
                $fp = fopen($file_name, 'w');
                foreach ($contents as $talk) {
                    $token = explode("<>", $talk);
                    if ($token[0] == $_POST["delete"]) {
                        unset($contents[array_search($talk, $contents)]);
                        continue;
                    }
                    else {
                        fwrite ($fp, $talk);
                    }
                }
                // index を詰める
                array_values($contents);
                fclose($fp);
            }
        }
    ?>
    <?php
        // 出力
        foreach($contents as $str) {
            $token = explode("<>", $str);
            foreach ($token as $i => $t) {
                if ($i != 4)
                    echo "{$t} ";
            }
            echo "<br>";
        }
    ?>

</body>
</html>
