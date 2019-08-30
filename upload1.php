<?php
/**
 * Created by PhpStorm.
 * User: 17853
 * Date: 2019/8/15
 * Time: 14:52
 */

$desFolder = "picture";    //文件上传根目录
date_default_timezone_set('PRC');  //获取中国时区，'PRC':中华人民共和国
if(!is_dir($desFolder)) //如果文件夹不存在，则创建一个
	mkdir($desFolder);

$fileName = $_FILES['file']['name'];  //文件名
$fileTmpName = $_FILES['file']['tmp_name'];  //临时文件名
$fileType = pathinfo($fileName,PATHINFO_EXTENSION);
$name="p".date("Ymd_His").".".$fileType;//规格化当前时间，将要作为上传文件的名称
$filePath = $desFolder."/".$name; //文件路径


$userid=$_POST['userid'];
$mysqli = new mysqli('127.0.0.1', 'root', '123456','index');//连接数据库
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

$sha = sha1_file($fileTmpName);//获得文件的sha1值

// $tmp['st1']=$fileName;
// $tmp['st2']=$fileType;
// $tmp['st3']=$sha;
// echo json_encode($tmp);
// mysqli_close($mysqli);
// return;

$sql = "select * from photos where sha1='$sha';";
$result = $mysqli->query($sql);

if($result->num_rows > 0) {//存在相同图片
	 
	$row = $result->fetch_assoc();
	$photoid = $row['id'];
	$is_moveorexist = true;
	$tmp['status0']=0;
}
else{//不存在相同图片
	$tmp['status0']=1;
	$tmp['0']=$filePath;
	$tmp['1']=$fileTmpName;
	$is_moveorexist = move_uploaded_file($fileTmpName, $filePath);//存储图片到服务器文件夹

	if($is_moveorexist){//如果存储成功

		$tmp['status1']=0;
		//查询最大id
		$sql="select max(id) as max_id from photos;";
		$result=$mysqli->query($sql);
		$max_id=0;
		if($row=$result->fetch_assoc()){
		    $max_id=$row['max_id']+1;
		}
		else{
		    $max_id=1;
		}


		//插入photos数据库
		$sql="insert into photos (id,name,photo,sha1,population) values ('$max_id','$name','$filePath','$sha',0);";
		$result=$mysqli->query($sql);
		if($result==1){//插入成功
		    $tmp['status2']=0;
		}
		else{//插入失败
		    $tmp['status2']=1;
		}
		$photoid = $max_id;

	}
	else{//如果存储失败
		$tmp['status1']=1;
	}
}
if($is_moveorexist){

	$sql = "select * from user_photo where userid='$userid' and photoid='$photoid';";
	$result = $mysqli->query($sql);

	if($result->num_rows > 0) {//已经关联
		 $tmp['status3']=0;
	}
	else{//未关联
		$tmp['status3']=1;
			//查询最大id
		$sql="select max(id) as max_id from user_photo;";
		$result=$mysqli->query($sql);
		if($row=$result->fetch_assoc()){
		    $max_id=$row['max_id']+1;
		}
		else{
		    $max_id=1;
		}


		$sql="insert into user_photo (id,userid,photoid) values ('$max_id','$userid','$photoid');";
		$result=$mysqli->query($sql);
		if($result==1){//插入成功
		    $tmp['status4']=0;
		}
		else{//插入失败
		    $tmp['status4']=1;
		}
	}


}


$response=json_encode($tmp);
echo $response;
mysqli_close($mysqli);


?>