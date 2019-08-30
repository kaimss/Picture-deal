<?php
/**
 * Created by PhpStorm.
 * User: 17853
 * Date: 2019/8/15
 * Time: 14:52
 */


$mysqli = new mysqli('127.0.0.1', 'root', '123456','index');//连接数据库
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

$userid=$_POST['userid'];

$sql = "select * from photos,user_photo where photos.id=user_photo.photoid and user_photo.userid='$userid';";
$result = $mysqli->query($sql);

$tmp=array();
if($result->num_rows > 0) {
	$tmp[0]['status']=0;
	while($row = $result->fetch_assoc()){
		array_push($tmp,$row);

	}
}
else{
	
	$tmp[0]['status']=1;

}


$response=json_encode($tmp);
echo $response;
mysqli_close($mysqli);


?>