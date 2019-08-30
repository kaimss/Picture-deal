<?php
/**
 * Created by PhpStorm.
 * User: 17853
 * Date: 2019/8/15
 * Time: 14:52
 */


$purpose=$_POST['purpose'];
$mysqli = new mysqli('127.0.0.1', 'root', '123456','index');//连接数据库
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

if($purpose==0){//通过photoid获取图片名称
	$photoid=$_POST['photoid'];
	$sql = "select * from photos where id='$photoid';";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	if($row>0){
		$row['status1']=0;


		$sql = "update photos set popular=popular+1 where id='$photoid';";
		$result = $mysqli->query($sql);
		if($mysqli->affected_rows==1){
		    $row['status2'] = 0;
		}
		else{
		    $row['status2'] = 1;
		}


		$tmp=$row;

	}
	else{
		$tmp['status1']=1;
	}
	$response=json_encode($tmp);
	echo $response;
}
else if($purpose==1){//收藏
	$userid=$_POST['userid'];
	$photoid=$_POST['photoid'];

	$sql = "select * from user_photo where userid='$userid' and photoid='$photoid';";
	$result = $mysqli->query($sql);
	if($result->num_rows > 0) {//自己原本就存储着这张图片
		$tmp['status2']=1;
	}
	else{//自己原来没有存储这张图片
		$tmp['status2']=0;
		//查询最大id
		$sql="select max(id) as max_id from user_photo;";
		$result=$mysqli->query($sql);
		if($row=$result->fetch_assoc()){
		    $max_id=$row['max_id']+1;
		}
		else{
		    $max_id=1;
		}

		$sql = "insert into user_photo (id,userid,photoid) values ('$max_id','$userid','$photoid');";
		$result = $mysqli->query($sql);
		if($result==1){//插入成功
		    $tmp['status3']=0;
		}
		else{//插入失败
		    $tmp['status3']=1;
		}
		
	}
	$response=json_encode($tmp);
	echo $response;
}
else if($purpose==2){//删除
	$userid=$_POST['userid'];
	$photoid=$_POST['photoid'];

	$sql = "delete from user_photo where userid='$userid' and photoid='$photoid';";
	$result = $mysqli->query($sql);
	if($result){
		$tmp['status4']=0;
	}
	else{
		$tmp['status4']=1;
	}
	
	$response=json_encode($tmp);
	echo $response;
}
mysqli_close($mysqli);


?>