<!DOCTYPE html>
<html>
    <head>
        <title>mission 1-5</title>
        <meta charset = "utf-8">
    </head>
    <body>
        <h1>ミッション1-5</h1>
        <form action="mission_1-5.php" method='post'>
            <input type="text" name="comment" value="コメント"/>
            <input type="submit" value="送信"/>
        </form>
        <?php
            if (isset($_POST["comment"])){
                if (strcmp($_POST['comment'], "コメント") === 0) {
                    echo "内容を変更してから送信しましょう";
                }
                elseif (strcmp($_POST['comment'], "") !== 0) {
                    if ($_POST['comment'] === "完成！") {
                        echo "おめでとう！";
                    }
                    else {
                        $time = date("Y-m-d H:i:s");
                        echo "ご入力ありがとうございます。<br>{$time}";
                        // echo $time; 
                        echo "に{$_POST["comment"]}を受け付けました<br>"; 
                    }
                    
                    $filename = 'mission_1-5_Gen.txt';
                    $fp = fopen($filename, 'w');
                    fwrite($fp, $_POST['comment']);
                    fclose($fp);
                }
            }
        ?>
    </body>
</html>
