<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHP Tutorial</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1>PHPアカデミア専用チュートリアル</h1>
    <h2>ミッション1-5</h2>
    <ul>
        <li><h3>if 文</h3>
            <ul>
<pre>
    if(条件式1){ 
        // 条件式1が真の時実行する
    } elseif (条件式2) 
        // 条件式1がfalseかつ条件式2がtrueの時
    } else {
        // ほかの場合
    }
</pre>
                <li>
                ifだけでも大丈夫、ifとelseだけあって、elseifがなくても大丈夫<br>
                </li>
            </ul>
        </li>
        <li><h3>文字列の比較</h3>
            <ul>
                <li><a href="http://php.net/manual/ja/language.operators.comparison.php">比較演算子</a>
                    <ul>
                        <li>$str = “12345”; // strを12345の”文字列”とする</li>
                        <li>$str == 12345; // true（型が違うが、変換後値が同じ）</li>
                        <li>$str === “12345”; // true（全く同じ）</li>
                        <li>$str !== “12345”; // false（全く同じ）</li>
                        <li>$str === 12345; // false （型が異なる）</li>
                        <li>$str !== 12345; // true （型が異なる）</li>
                        <li>$str != 12345; // false（変換後値が同じ）</li>
                        <li>$str <> 12345; // false（変換後値が同じ）</li>
                    </ul>
                </li>
                <li><a href="http://php.net/manual/ja/function.strcmp.php">strcmp関数</a>
                    <ul>
                        <li>同じだったら0を返す</li>
                                <pre>
    $str1 = “Hello”;
    $str2 = “World”;
    if (strcmp($str1, $str2)===0){
        // $str1 and $str2 are the same
    } else {
        // $str1 and $str2 are different
    }
                                </pre>
                    </ul>
                </li>
            </ul>
        </li>
        <li><h3>書き込み</h3>
            <ul>
                <li><a href="http://php.net/manual/ja/function.fopen.php">fopen</a></li>
                <pre>
                    $fp = fopen(filename, "w");
                    "w" は書き込むの意味、ほかにも"r"読み込むモードとかがある、詳細はリファレンスを参照こと。
                </pre>
                <li><a href="http://php.net/manual/ja/function.fwrite.php">fwrite</a></li>
            </ul>
        </li>
        <li><h3>書き込んだファイルの内容を確認</h3>
            <ol>
                <li>FTPクライアント（MacだとFileZilla、WindowsだとFFFTP）からダウンロードし、テキストエディタで開いて確認する</li>
                <li>ブラウザで自分のホームディレクトリから開く。こうすると、多くの場合は文字化けするので、以下のようにテキストエンコーディングをUTF-8に設定してすれば解決できるはず。
                    <img src="encoding.jpg" alt="encoding-setting" width="800">
                </li>
            </ol>
        </li>
    </ul>

    <a href="../tutorial.php">ホームページ</a>
</body>
</html>