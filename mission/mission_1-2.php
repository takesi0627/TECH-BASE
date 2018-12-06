<?php
$filename = 'mission_1-2.txt';
$fp = fopen($filename, 'w');
fwrite($fp, 'test');
fclose($fp);
?>
