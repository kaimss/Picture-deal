<?php
/**
 * Created by PhpStorm.
 * User: 17853
 * Date: 2019/8/14
 * Time: 10:01
 */

$mysqli = new mysqli('127.0.0.1', 'root', '123456','test');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}
$sql = "SELECT aa,bb,cc FROM test";
$result =$mysqli->query($sql);

if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        echo "aa: " . $row["aa"]. " - bb: " . $row["bb"]. " " . $row["cc"]. "<br>";
    }
} else {
    echo "0 结果";
}
//echo 'Connection OK';





$mysqli->close();
?>