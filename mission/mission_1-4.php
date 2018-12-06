<!DOCTYPE html>
<html>
    <head>
        <title>mission 1-4</title>
        <meta charset = "utf-8">
    </head>
    <body>
        <h1>ミッション1-4</h1>
        <form action="mission_1-4.php" method='post'>
            <input type="text" name="comment" value="コメント"/>
            <input type="submit" value="送信"/>
        </form>
        <?php
            if (isset($_POST["comment"])){
                $time = date("Y-m-d H:i:s");
                echo "ご入力ありがとうございます。";
                echo '<br>';   
                echo $time; 
                echo "に"; 
                echo $_POST["comment"];
                echo "を受け付けました";
            }
        ?>
    </body>
</html>
