<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="div.css">
    <script src="https://lib.sinaapp.com/js/jquery/2.0.2/jquery-2.0.2.min.js"></script>
    <title>展示</title>
</head>
<body>
<nav class="navbar navbar-default navbar-inverse " role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">index</a>
    </div>
    <div>
        <ul class="nav navbar-nav">
            <li><a href="main.html">main</a></li>
            <li><a href="upload.html">upload</a></li>
            <li class="active"><a href="show.php">show</a></li>
            <li><a href="javascript:void(0);" onclick="logout(this)">logout</a></li>
        </ul>
    </div>
</nav>
<br>
<!--主体-->
<div class="container-fluid main">
    <!--    左边-->
    <div class="col-sm-1"></div>
    <!--    中间-->
    <div class="col-sm-10">
        <?php
        $mysqli = new mysqli('127.0.0.1', 'root', '123456','index');

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
        }
        $item = explode('=', $_SERVER["REQUEST_URI"]);
        $id=$item[1];
        $query="select * from photo where id='$id'";
        $result=mysqli_query($mysqli,$query);
        if(mysqli_num_rows($result)>0) {
            while($row=mysqli_fetch_assoc($result)) {

                ?>
                <div class="col-sm-offset-1">
                    <img  onclick="view(this)" width="500px" src="data:image/jpg;base64,<?= base64_encode($row['photo']) ?>">
                    <span style="opacity:0.0;"><?= $id ?></span>
                </div>
                <?php
            }
        }
        mysqli_close($mysqli);
        ?>

        <div style="margin-top:10px;">
            <div class=" btn-group btn-group-default" style="margin-left:100px;">
                <button type="button" class="btn btn-primary" id="return">返回</button>
            </div>
<!--            <div class="btn-group btn-group-default" style="margin-left:50px;">-->
<!--                <button type="button" class="btn btn-primary" id="register">返回</button>-->
<!--            </div>-->
        </div>
    </div>

    <!--    右边-->
    <div class="col-sm-1"></div>

</div>

</body>
<script>
    $(document).ready(function(){

        var user = sessionStorage.getItem("user");
        if(user==null){
            alert("请登录");
            window.location.href="index.html";
        }
        user = JSON.parse(user);
        console.log("user",user);

        $("#return").click(function(){
            window.location.href="show.php";
        })
        //add();
    });

    // function add()
    // {
    //     var id = sessionStorage.getItem("id");
    //     sessionStorage.removeItem("id");
    //     alert(id);
    //     $.ajax({
    //         type: "POST",
    //         url: "index.php",
    //         data: {"id":id, "purpose":2},
    //         dataType: "text",
    //         success: function(data)
    //         {   //返回值
    //             console.log("data",data)
    //             // let obj = JSON.parse(data);
    //             // let response = obj.status;
    //             // console.log("response",response);
    //             // if(response == "0")
    //             // {
    //             //     console.log(obj);
    //             // }
    //             // else if(response == "1")
    //             // {//查询失败
    //             //
    //             // }
    //         },
    //         error: function(jqXHR,textStatus,errorThrown)
    //         {
    //             console.log(jqXHR);
    //             console.log(textStatus);
    //             console.log(errorThrown)
    //         }
    //     });
    // }
    function logout(t)
    {
        sessionStorage.removeItem("user");
        window.location.href="index.html";
    }

</script>
</html>