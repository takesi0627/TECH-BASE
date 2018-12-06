<!DOCTYPE html>
<html>
    <head>
        <title>mission 1-6</title>
        <meta charset = "utf-8">
    </head>
    <body>
        <h1>ミッション1-6</h1>
        <form action="mission_1-6.php" method='post'>
            <input type="text" name="comment" value="コメント"/>
            <input type="submit" value="送信"/>
        </form>
        <?php
            if (isset($_POST["comment"])){
                if (strcmp($_POST['comment'], "コメント") === 0) {
                    echo "内容を変更してから送信しましょう";
                }
                elseif (strcmp($_POST['comment'], "") !== 0) {
                    $time = date("Y-m-d H:i:s");
                    echo "ご入力ありがとうございます。<br>$time";
                    // echo $time; 
                    echo "に"; 
                    echo $_POST["comment"];
                    echo "を受け付けました<br>";

                    $filename = 'mission_1-6_Gen.txt';
                    $fp = fopen($filename, 'a');
                    fwrite($fp, $_POST['comment']);
                    fwrite($fp, "\n");
                    fclose($fp);
                }
            }
        ?>
    </body>
</html>
