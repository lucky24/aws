<?php
$string =  $_SERVER['QUERY_STRING'];
for($i = 0; $i < strlen($string); $i++) {
  if (!in_array($string[$i], array(
    '+', '-', '*', '/', '(', ')',
    '0', '1', '2', '3', '4',
    '5', '6', '7', '8', '9'
  ))) {
    die("ERROR");
  }
}
echo eval("echo $string;") . "\n";
