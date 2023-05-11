<?php
//连接数据库
include("connect.php");


// 获取POST请求中的数据并进行安全性验证
$movieid = mysqli_real_escape_string($conn, $_POST["movieid"]);


if (isset($_POST["releasetime"])) {
    $releasetime_str = mysqli_real_escape_string($conn, $_POST["releasetime"]);
    $releasetime = date('Y-m-d', strtotime($releasetime_str)); // 将日期字符串转换为指定的日期格式
    $releasetime = mysqli_real_escape_string($conn, $releasetime);
} else {
    $releasetime = "2000-01-01";
}
if (isset($_POST["moviename"])) {
    $moviename = mysqli_real_escape_string($conn, $_POST["moviename"]);
} else {
    $moviename = "";
}
if (isset($_POST["duration"])) {
    $duration = mysqli_real_escape_string($conn, $_POST["duration"]);
} else {
    $duration = "";
}
if (isset($_POST["language"])) {
    $language = mysqli_real_escape_string($conn, $_POST["language"]);
} else {
    $language = "";
}

if (isset($_POST["country"])) {
    $country = mysqli_real_escape_string($conn, $_POST["country"]);
} else {
    $country = "";
}

// 更新用户信息
$sql = "UPDATE movie SET  moviename='$moviename', duration='$duration', language='$language',country='$country',releasetime='$releasetime' WHERE movieid='$movieid'";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("电影信息已更新");</script>';
    echo '<script>window.location.href = "moviemanage.php";</script>';
} 



$conn->close();
?>