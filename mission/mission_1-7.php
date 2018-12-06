<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <title>mission 1-7</title>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
    <!-- <script src="main.js"></script> -->
</head>
<body>
    <h1>ミッション1-7</h1>
        <form action="mission_1-7.php" method='post'>
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

                    $filename = 'mission_1-7_Gen.txt';
                    $fp = fopen($filename, 'a');
                    fwrite($fp, $_POST['comment']);
                    fwrite($fp, "\n");
                    fclose($fp);
                }
            }
        ?>
    <?php
        if (isset($_POST["comment"]) && strcmp($_POST['comment'], '') !== 0){
            $file_name = "mission_1-7_Gen.txt";
            if (file_exists($file_name)) {
                $contents = file($file_name);
                foreach ($contents as $str) {
                    # code...
                    echo "$str<br>";
                }        
            }
        }
    ?>
    
</body>
</html>