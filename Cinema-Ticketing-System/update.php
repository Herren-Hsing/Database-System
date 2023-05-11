<?php
//连接数据库
include("connect.php");

// 获取COOKIE中的userid
$userid = $_COOKIE["userid"];

// 获取POST请求中的数据并进行安全性验证
if (isset($_POST["gender"])) {
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
} else {
    $gender = "";
}
if (isset($_POST["birthday"])) {
    $birthday_str = mysqli_real_escape_string($conn, $_POST["birthday"]);
    $birthday = date('Y-m-d', strtotime($birthday_str)); // 将日期字符串转换为指定的日期格式
    $birthday = mysqli_real_escape_string($conn, $birthday);
} else {
    $birthday = "2000-01-01";
}
if (isset($_POST["phone"])) {
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
} else {
    $phone = "";
}
if (isset($_POST["motto"])) {
    $motto = mysqli_real_escape_string($conn, $_POST["motto"]);
} else {
    $motto = "";
}

// 更新用户信息
$sql = "UPDATE user SET  gender='$gender', birthday='$birthday', phone='$phone', motto='$motto' WHERE userid='$userid'";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("用户信息已更新");</script>';
    echo '<script>window.location.href = "information.php";</script>';
} else {
    echo '<script>alert("更新失败: '.$conn->error.'");</script>';
}


$conn->close();
?>