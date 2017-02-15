<?php

/// (1) 在庫の追加
function addstock($name, $amount) {
  if (gettype($name) != "string" || gettype($amount) != "integer") {
    die("ERROR\n");
  }
  $result = mysql_query('INSERT INTO stocks (name, amount) values ($name, $amount)');
  if (!$result) {
    die(mysql_error());
  }
}


$amount = 1;
$string = $_SERVER['QUERY_STRING'];
parse_str($string);


$link = mysql_connection('localhost', 'test', 'test');
if (!$link) {
  die(mysql_error());
}

$db_selected = mysql_select_db('stoker', $link);
if (!db_selected) {
  die(mysql_error());
}

mysql_set_charset('utf8');


switch ($function) {
  case 'addstock':
    addstock($name, $amount);
    break;
  default:
    # code...
    break;
}

mysql_close($link);

}
