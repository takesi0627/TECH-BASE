<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Create Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
<center>
    <h1>アカウント作成</h1>
    <hr>
    <form action="" method="post">
        <input type="text" name="account" id="account" placeholder="アカウント名"><br>
        <input type="text" name="name" id="name" placeholder="表示名"><br>
        <input type="password" name="password" id="password" placeholder="パスワード"><br>
        <input type="password" name="password2" id="password2" placeholder="パスワード再入力"><br>
        <input type="email" name="email" id="email" placeholder="Eメイルアドレス"><br>
        <input type="email" name="email2" id="email2" placeholder="Eメイルアドレス再入力"><br>
        <input type="submit" value="アカウント作成">
    </form>
    <hr>
    <a href="./index.php">ホームに戻る</a> <a href="login.php">ログイン</a><br>

<?php
    require("src/init.php");

    $check_flag = TRUE;

    // check passwords are the same
    if (!empty($_POST["password"]) && !empty($_POST["password2"])) {
        if ($_POST["password"] !== $_POST["password2"]) {
            echo "パスワードが一致していません。<br>";
            $check_flag = FALSE;
        }
    } elseif (empty($_POST["password"]) xor empty($_POST["password2"])) {
        echo "パスワードを二回入力してください。<br>";
        $check_flag = FALSE;
    } 

    if (!empty($_POST["email"]) && !empty($_POST["email2"])) {
        if ($_POST["email"] !== $_POST["email2"]) {
            echo "Eメイルアドレスが一致していません。<br>";
            $check_flag = FALSE;
        }
    } elseif (empty($_POST["email"]) xor empty($_POST["email2"])) {
        echo "Eメイルアドレスを二回入力してください。<br>";
        $check_flag = FALSE;
    }

    if (!empty($_POST["account"]) and !empty($_POST["name"]) and !empty($_POST["password"]) and !empty($_POST["email"]) and $check_flag) {
        // create account and 
        if (CreateAccount($pdo, $_POST["account"], $_POST["name"], $_POST["password"], $_POST["email"])){
            echo "アカウントが作成されました。<br>";
        }
        else {
            echo "アカウントの作成が失敗しました。<br>";
        }
    }    

?>
</center>
</body>

</html>