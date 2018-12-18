<?php
    require("src/init.php");
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <center>
    <h1>ログイン</h1>
    <hr>
    <form action="login.php" method="post">
        <label for="account">ユーザーID</label><input type="text" name="account" id="account" placeholder="ユーザーIDを入力"
        value="<?php if(!empty($_POST["account"])) echo htmlspecialchars($_POST["account"], ENT_QUOTES);?>"> <br>
        <label for="password">パスワード</label><input type="password" name="pwd" id="pwd" placeholder="パスワードを入力" 
        value="<?php if(!empty($_POST["password"])) echo htmlspecialchars($_POST["password"], ENT_QUOTES);?>"> <br>
        <input type="submit" id="login" name="login" value="ログイン">
    </form>
    <form action="create_account.php">
        <input type="submit" name="signup" value="新規登録"><br>
    </form>
    <!-- <p>アカウントをお持ちしていない方は<a href="./create_account.php">こちら</a>で作ってください</p><br> -->
    <?php
        // if login button has been pushed
        if (isset($_POST["login"])) {
            if (!empty($_POST["pwd"]) and !empty($_POST["account"])) {
                if (CheckPassword($pdo, $_POST["account"], $_POST["pwd"])) {
                    echo "成功";
                    $_SESSION["USERID"] = GetAccountID($pdo, $_POST["account"]);
                    $_SESSION["USERNAME"] = GetName($pdo, $_SESSION["USERID"]);
                    header("location: index.php");
                }
                else {
                    echo "失敗";
                }
            }
        }
    ?>
    </center>
</body>
</html>