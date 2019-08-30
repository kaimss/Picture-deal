<?php
/**
 * Created by PhpStorm.
 * User: 17853
 * Date: 2019/8/14
 * Time: 9:46
 */

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
else if($purpose==1)//注册
{
    $mysqli = new mysqli('127.0.0.1', 'root', '123456','index');
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }

    $username=$_POST['username'];
    $password=$_POST['password'];

    $sql="select max(userid) as maxuserid from user;";
    $result=mysqli_query($mysqli,$sql);
    $max_id=0;
    if($row=mysqli_fetch_assoc($result)){
        $max_id=$row['maxuserid']+1;
    }
    else{
        $max_id=1;
    }
    $sql = "insert into user (userid,username,password) values ('$max_id','$username',$password)";
    $result =$mysqli->query($sql);

    if($result>0){//注册成功
            $row['status']=0;//注册成功标志
            $response=json_encode($row);
    }
    else{//注册失败
        $tmp['status']=1;//注册失败标志
        $response=json_encode($tmp);
    }

    mysqli_close($mysqli);
    echo $response;
}
else if($purpose==2)//根据photo的id从数据库中查询图片数据
{
    $mysqli = new mysqli('127.0.0.1', 'root', '123456','index');
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }

    $id=$_POST['id'];

    $sql="select * from photo where id='$id'";
//    $result =$mysqli->query($sql);
//    $row = $result->fetch_assoc();
    $result=mysqli_query($mysqli,$sql);
    $row = mysqli_fetch_assoc($result);

    if($row>0){//查询成功
        $row['status']=0;//查询成功标志
        $response=json_encode($row);

    }
    else{//查询失败
        $tmp['status']=1;//查询失败标志
        $response=json_encode($tmp);
    }

    mysqli_close($mysqli);
    echo $response;
}