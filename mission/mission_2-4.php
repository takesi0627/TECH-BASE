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
        $page_path = "mission_2-4.php";
        $file_name = "mission_2_history.txt";
        $contents = array();
        if (file_exists($file_name)) {
            $contents = file($file_name);
        }
    ?>
    <center>
        <h1>WEB掲示板</h1>
        <form action=<?php echo $page_path; ?> method='post'>
            <input type="text" name="name" placeholder="名前"
            <?php 
                if (isset($_POST["edit"])) {
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
                if (isset($_POST["edit"])) {
                    foreach ($contents as $str) {
                        $token = explode("<>", $str);
                        if ($token[0] == $_POST["edit"]) {
                            echo "value=\"{$token[2]}\"";
                        }
                    }
                }
            ?>
            /><br>
            <?php
                if (isset($_POST["edit"])) {
                    echo "<input type=\"hidden\" name=\"edit_no\" value=\"{$_POST["edit"]}\"<br>";
                }
            ?>
            <input type="submit" value="送信"/><br>
        </form>
        <br>
        <form action=<?php echo $page_path; ?> method='post'>
            <input type="text" name="delete" placeholder="削除対象番号"/>
            <input type="submit" value="削除"/><br>
        </form>
        <form action=<?php echo $page_path; ?> method='post'>
            <input type="text" name="edit" placeholder="編集対象番号"/>
            <input type="submit" value="編集"/><br>
        </form>
        <hr>
    </center>

    <?php
        if (isset($_POST["comment"])){
            if (strcmp($_POST['comment'], "コメント") === 0) {
                echo "内容を変更してから送信しましょう";
            }
            elseif (strcmp($_POST['comment'], "") !== 0) {
                $time = date("Y-m-d H:i:s");
                $comment = $_POST["comment"];
                $name = $_POST["name"];

                if (isset($_POST["edit_no"])) {
                    $number = $_POST["edit_no"];
                    $new_content = "{$number}<>{$name}<>{$comment}<>{$time}";
                    
                    $fp = fopen($file_name, 'w');
                    foreach ($contents as &$str) {
                        $token = explode("<>", $str);
                        if ($token[0] == $number) {
                            $str = $new_content;
                        }
                        fwrite ($fp, "{$str}\n");
                    }
                    fclose($fp);
                    unset($str); 
                }
                else {
                    // get the last number of the comment in the file and plus 1
                    $last_token = explode("<>", end($contents));
                    $number = $last_token[0] + 1;
                    
                    $new_content = "{$number}<>{$name}<>{$comment}<>{$time}";
                    array_push($contents, $new_content);

                    $fp = fopen($file_name, 'a');
                    fwrite($fp, "{$new_content}\n");
                    fclose($fp);
                }
            }
            else {
                echo "コメントは空欄です。<br>";
                echo "<hr>";
            }
        }

        if (isset($_POST["delete"])) {
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
    ?>
    <?php
        // 出力
        foreach($contents as $str) {
            $token = explode("<>", $str);
            foreach ($token as $t) {
                echo "{$t} ";
            }
            echo "<br>";
        }
    ?>

</body>
</html>