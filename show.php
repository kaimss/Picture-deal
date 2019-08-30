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
        $query="select id,name,photo,userid from photo where userid='$id'";
        $result=mysqli_query($mysqli,$query);
        if(mysqli_num_rows($result)>0) {
            while($row=mysqli_fetch_assoc($result)) {

                ?>
                <div class="subcontent">
                    <div class="subcon_photo" align="center">
                        <img  onclick="view(this)"  width="140px" height="180px" src="data:image/jpg;base64,<?= base64_encode($row['photo']) ?>">

                    </div>

                    <span style="opacity:0.0"><?= $row['id'] ?></span>
                </div>
                <?php
            }
        }
        mysqli_close($mysqli);
        ?>
    </div>
    <!--    右边-->
    <div class="col-sm-1"></div>

    </div>
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
    });

    function view(t)
    {
        var p=t.parentNode.parentNode.children[1];
        var q=p.innerHTML;
        //sessionStorage.setItem("id",q);
        window.location.href="photo.php?id="+q;
    }

    function logout(t)
    {
        sessionStorage.removeItem("user");
        window.location.href="index.html";
    }
</script>
</html>
