<!DOCTYPE html>
<html>

<?php
    require("init.php");
?>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <textarea name="command" form="sql" cols="30" rows="10"></textarea>
    <form action="database.php" id="sql" method="post">
        <!-- <label for="sql_cmd">SQL Command:</label> -->
        <!-- <input type="text" name="command" id="sql_cmd"> -->
        <input type="submit" value="send">
    </form>

    <?php

        if (!empty($_POST["command"])) {
            $sql = $_POST["command"];
            $stmt = $pdo->query($sql);
            $res = $stmt->fetchAll();

            display_data($res);
        }

        function display_data($data) {
            $output = "<table>";
            foreach($data as $key => $var) {
                //$output .= '<tr>';
                if($key===0) {
                    $output .= '<tr>';
                    foreach($var as $col => $val) {
                        $output .= "<td>" . $col . '</td>';
                    }
                    $output .= '</tr>';
                    foreach($var as $col => $val) {
                        $output .= '<td>' . $val . '</td>';
                    }
                    $output .= '</tr>';
                }
                else {
                    $output .= '<tr>';
                    foreach($var as $col => $val) {
                        $output .= '<td>' . $val . '</td>';
                    }
                    $output .= '</tr>';
                }
            }
            $output .= '</table>';
            echo $output;
        }
    ?>
    
</body>
</html>