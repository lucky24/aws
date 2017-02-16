<?php

// (1) add stocker
function add_stock($name, $amount=1) {
  if ($name != '*') {
    $sql = "INSERT INTO stocks (name, amount) VALUES ('$name', $amount)";
    $result = mysql_query($sql);
    if (!$result) {
      die(mysql_error());
    }
  }
}

// (2) check stock
function check_stock($name="*") {
  if ($name == '*') {
    $sql = "SELECT * FROM stocks ORDER BY name ASC";
  } else {
    $sql = "SELECT name, amount FROM stocks WHERE name='$name' ORDER BY name ASC";
  }
  $result = mysql_query($sql);
  if (!$result) {
    die(mysql_error());
  }

  $cnt=0;
  while ($row = mysql_fetch_assoc($result)) {
    echo($row['name']. ": ". $row['amount']. "\n");
    if ($row['amount'] == 0) {
      echo("0\n");
    }
    $cnt++;
  }
  if ($cnt == 0) {
    echo("0\n");
  }
}

// (3) sell stocke
function sell_stock($name, $amount=1, $price=0) {
  $sql = "SELECT amount FROM stocks WHERE name='$name'";
  $result = mysql_query($sql);
  if (!$result) {
    die(mysql_error());
  }
  $row = mysql_fetch_assoc($result);
  if ($row['amount'] >= $amount) {
    $sql = "UPDATE stocks SET amount=amount-'$amount' WHERE name='$name'";
    $result = mysql_query($sql);
    if (!$result) {
      die(mysql_error());
    }
    $sql = "UPDATE sales SET sales=sales+'$price'*'$amount'";
    $result = mysql_query($sql);
    if (!$result) {
      die(mysql_error());
    }
  }
}

// (4) check sales
function check_sales() {
  $sql = "SELECT * FROM sales";
  $result = mysql_query($sql);
  if (!$result) {
    die(mysql_error());
  }
  $row = mysql_fetch_assoc($result);
  $sales = number_format($row['sales']);
  if (is_int($sales)) {
    echo ("sales: ". $sales . "\n");
  } else {
    echo ("sales: ". number_format($sales,2) . "\n");
  }
}

// delete all
function delete_all() {
  $sql = "TRUNCATE TABLE stocks";
  $result = mysql_query($sql);
  $sql = "TRUNCATE TABLE sales";
  $result = mysql_query($sql);
  $sql = "INSERT INTO sales (sales) VALUES (0)";
  $result = mysql_query($sql);
}

$amount = '1';
$price = '0';
$name = '*';
$string = $_SERVER['QUERY_STRING'];
parse_str($string);

$link = mysql_connect('localhost', 'root', '');
if (!$link) {
  die(mysql_error());
}

$db_selected = mysql_select_db('stocker', $link);
if (!$db_selected) {
  die(mysql_error());
}

mysql_set_charset('utf8');

for ($i = 0; $i < strlen($amount); $i++) {
  if (!in_array($amount[$i], array(
    '0', '1', '2', '3', '4',
    '5', '6', '7', '8', '9'
  ))) {
    die("ERROR : amount is not integer\n");
  }
}

$amount = intval($amount);
$price = intval($price);

switch ($function) {
  case 'addstock':
    add_stock($name, $amount);
    break;
  case 'checkstock':
    check_stock($name);
    break;
  case 'sell':
    sell_stock($name, $amount, $price);
    break;
  case 'checksales':
    check_sales();
    break;
  case 'deleteall':
    delete_all();
    break;
  default:
    # code...
    break;
}

mysql_close($link);
