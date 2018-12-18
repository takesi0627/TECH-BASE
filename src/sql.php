<?php
/**
 * sql functions
 */
    function ConnectDB (){
        $login_info = file("login_info", FILE_USE_INCLUDE_PATH);
        for ($i=0; $i < count($login_info); $i++) { 
            $tokens = explode("=", $login_info[$i]);
            if ($i == 0) 
                $db_name = trim($tokens[1]);
            elseif ($i == 1)
                $user = trim($tokens[1]);
            elseif ($i == 2)
                $password = trim($tokens[1]);
        }

        $dsn = "mysql:dbname={$db_name};host=localhost";
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        return $pdo;    
    }

    function DropTable (PDO &$pdo, $table) {
        $sql = "DROP TABLE tbtest;";
        $stmt = $pdo->query($sql);
        // $stmt->bindParam(":table", $table, PDO::PARAM_STR);
        // $stmt->execute();
    }

    function CreateDB (PDO &$pdo) {
        $sql = "CREATE TABLE IF NOT EXISTS tbtest (".
            "id INT,". 
            "name char(32),".
            "comment TEXT,".
            "password char(32),".
            "time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,". // データ入力するとき自動的に時間を入れる
            "PRIMARY KEY(id)".
            ");";
        $stmt = $pdo->query($sql);
    }

    function ShowResult (PDO &$pdo) {
        $sql = "SELECT * FROM tbtest ORDER BY id;";
        $stmt = $pdo -> query($sql);
        $results = $stmt->fetchAll();
    
        foreach ($results as $row) {
            echo "{$row['id']} {$row['name']} {$row['time']}　{$row['comment']}<br>";
        }    
    }

    function InsertComment(PDO &$pdo, $id, $comment) {
        $sql = "INSERT INTO comments (account_id, comment) VALUES (:id, :comment)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam (":id", $id, PDO::PARAM_INT);
        $stmt->bindParam (":comment", $comment, PDO::PARAM_STR);
        $stmt->execute ();
    }

    function DeleteComment (PDO &$pdo, $id) {
        $sql = "DELETE FROM comments WHERE id=:id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    function Update (PDO &$pdo, $id, $new_name, $new_comment) {
        $sql = "UPDATE tbtest SET name=:name, comment=:comment WHERE id=:id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":name", $new_name, PDO::PARAM_STR);
        $stmt->bindParam(":comment", $new_comment, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    function GetLastNumber (PDO &$pdo) {
        $sql = "SELECT id FROM tbtest ORDER BY id;";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();

        if (count($results) > 0) {
            $last = end($results);
            return $last['id'];
        } 
        else {
            return 0;
        }
    }

    function GetComment (PDO &$pdo, $id) {
        $sql = "SELECT comment FROM tbtest WHERE id=:id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchColumn();
        return $res;        
    }

    function CheckCommentOwner (PDO &$pdo, $account_id, $comment_id) {
        $sql = "SELECT * FROM comments WHERE id=:comment_id AND account_id=:account_id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
        $stmt->bindParam(":account_id", $account_id, PDO::PARAM_INT);
        $stmt->execute();

        $res = $stmt->fetchAll();
        if (count($res) == 1)
            return true;
        else 
            return false;
    }
 
    function CheckPasswordByID (PDO &$pdo, $id, $password) {
        $sql = "SELECT id, password FROM account WHERE id=:id AND password=:password;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetchAll();
        if (count($res) == 1) 
            return true;
        else 
            return false;
    }
    
    function CheckPassword (PDO &$pdo, $account, $password) {
        $sql = "SELECT account, password FROM account WHERE account=:account AND password=:password;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":account", $account, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetchAll();
        if (count($res) == 1) 
            return true;
        else 
            return false;
    }

    function CreateAccount (PDO &$pdo, $account_name, $name, $password, $email) {
        $sql = "INSERT INTO account(account, show_name, password, mail_address) VALUES (:account, :name, :password, :email);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":account", $account_name, PDO::PARAM_STR);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    function GetAccountID (PDO &$pdo, $account) {
        $sql = "SELECT id FROM account WHERE account=:account";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":account", $account, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }
    }

    function GetName (PDO &$pdo, $id) {
        $sql = "SELECT show_name FROM account WHERE id=:id;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchColumn();
        return $res;
    }
?>