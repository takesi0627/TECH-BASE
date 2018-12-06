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
    <center>
        <h1>WEB掲示板</h1>
        <form action="mission_2-2.php" method='post'>
            名前：<input type="text" name="name"/><br>
            コメント：<input type="text" name="comment"/><br>
            <input type="submit" value="送信"/>
        </form>
        <h4>-------------------------------------------------------------</h4>
    </center>
    <?php
        $file_name = "mission_2-2_history.txt";
        $number = 0;
        if (file_exists($file_name)) {
            $contents = file($file_name);
            $number = count($contents);
            foreach ($contents as $str) {
                $tokens = explode("<>", $str);
                foreach($tokens as $t) {
                    echo "{$t} ";
                }
                echo "<br>";
            }
        }

        if (isset($_POST["comment"])){
            if (strcmp($_POST['comment'], "コメント") === 0) {
                echo "内容を変更してから送信しましょう";
            }
            elseif (strcmp($_POST['comment'], "") !== 0) {
                $time = date("Y-m-d H:i:s");
                $comment = $_POST["comment"];
                $name = $_POST["name"];

                $number += 1;
                $content = "{$number}<>{$name}<>{$comment}<>{$time}\n";
                
                // print new comment
                $tokens = explode("<>", $content);
                echo "{$tokens[0]} {$tokens[1]} {$tokens[2]} {$tokens[3]}";
                //foreach ($tokens as $t) {
                //    echo "{$t} ";
                //}
                echo "<br>";

                $fp = fopen($file_name, 'a');
                fwrite($fp, $content);
                fclose($fp);
            }
            else {
                echo "コメントは空欄です。";
            }
        }   
    ?>

</body>
</html>
