<?php
/**
 * Created by PhpStorm.
 * User: 17853
 * Date: 2019/8/14
 * Time: 15:48
 */
// 连接数据库
$mysqli = new mysqli('127.0.0.1', 'root', '123456','index');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}
$userid=$_POST['userid'];
if ($_FILES["photo"]["error"] > 0)
{
    $tmp['status']=2;//
    $response=json_encode($tmp);
    //echo "Error: " . $_FILES["photo"]["error"] . "<br />";
}
else
{
    $fp=fopen($_FILES['photo']['tmp_name'],'rb');
    if(!$fp){
//        $tmp['status']=3;//
//        $response=json_encode($tmp);
        header("location:upload.html?1");

    }
    else{
        $picture=addslashes(fread($fp,filesize($_FILES['photo']['tmp_name'])));
        $sql="select max(id) as max_id from photo;";
        $result=mysqli_query($mysqli,$sql);
        $max_id=0;
        if($row=mysqli_fetch_assoc($result)){
            $max_id=$row['max_id']+1;
        }
        else{
            $max_id=1;
        }
        $sql="insert into photo (id,name,photo,userid) values ('$max_id','name','$picture','$userid');";
        $result=mysqli_query($mysqli,$sql);
        if($result==1){//插入成功
            //$tmp['status']=0;
            //$response=json_encode($tmp);
            header("location:upload.html?0");
        }
        else{//插入失败
            //$tmp['status']=1;//
           // $response=json_encode($tmp);
            header("location:upload.html?1");
        }


    }

}
mysqli_close($mysqli);
echo $response;


?>