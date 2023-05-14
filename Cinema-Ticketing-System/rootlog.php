<?php
//连接数据库
include("connect.php");

//获取表单数据
$adminname = $_POST['adminname'];
$password = $_POST['password'];

//查询用户
$sql = "select adminid from admin where adminname = '$adminname' and password = '$password'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    //将用户名存储到会话中
    session_start();
    $_SESSION['adminname'] = $adminname;

    //从数据库中查询用户ID
    $query = "SELECT adminid FROM admin WHERE adminname='$adminname'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $adminid = $row['adminid'];

    //将用户ID存储到cookie中
    $expire_time = time() + 3600; //设置cookie的过期时间为1小时
    setcookie("adminid", $adminid, $expire_time);
    setcookie("adminname", $adminname, $expire_time);
    //跳转到主页index.php
    echo "<script>url=\"moviemanage.php\";window.location.href=url;</script>";
} else {
    //没有查询到该用户，弹出一个对话框"用户名或密码错误"，并返回rootlog.html页面
    echo "<script>alert(\"用户名或密码错误\");</script>";
    echo "<script>url=\"rootlog.html\";window.location.href=url;</script>";
}

//关闭数据库
mysqli_close($conn);
?>