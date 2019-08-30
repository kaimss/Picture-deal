<?php
/**
 * Created by PhpStorm.
 * User: 17853
 * Date: 2019/8/14
 * Time: 9:46
 */
// 连接数据库
//$mysqli = new mysqli('127.0.0.1', 'root', '123456','index');
//if ($mysqli->connect_error) {
//    die('Connect Error (' . $mysqli->connect_errno . ') '
//        . $mysqli->connect_error);
//}
//
//$username=$_POST['username'];
//$password=$_POST['password'];
//$sql = "SELECT * FROM user where username='$username' and password='$password';";
//$result =$mysqli->query($sql);
//$row = $result->fetch_assoc();
//if($row>0){//登录成功
//    header("Location:http://localhost/sjzy/main.html");
//}
//else{//登录失败
//    header("Location:http://localhost/sjzy/index.html");
//}
//
//mysqli_close($mysqli);
$purpose=$_POST['purpose'];
if($purpose==0)//登录
{
    $mysqli = new mysqli('127.0.0.1', 'root', '123456','index');
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }

    $username=$_POST['username'];
    $password=$_POST['password'];
    $sql = "SELECT * FROM user where username='$username';";
    $result =$mysqli->query($sql);
    $row = $result->fetch_assoc();

    if($row>0){//用户存在
        if($row['password']==$password){
            $row['status']=0;//成功登录标志
            $response=json_encode($row);
        }
        else{//密码错误
            $tmp['status']=1;//密码错误标志
            $response=json_encode($tmp);
        }
    }
    else{//用户不存在
        $tmp['status']=2;//用户不存在标志
        $response=json_encode($tmp);
    }

    mysqli_close($mysqli);
    echo $response;
}