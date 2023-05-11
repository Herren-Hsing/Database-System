<?php
// 连接数据库
include("connect.php");

// 从 GET 参数中获取电影 ID
$movieid = $_GET["movieid"];

// 从 movie 表中获取电影信息
$sql = "SELECT * FROM movie WHERE MovieID = '$movieid'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("查询电影信息失败：" . mysqli_error($conn));
}

// 将电影信息显示在表单中
$row = mysqli_fetch_assoc($result);
echo '<form>';
echo '<label>电影名称：<input type="text" name="moviename" value="' . $row["MovieName"] . '"></label><br>';
echo '<label>电影时长：<input type="text" name="duration" value="' . $row["Duration"] . '"></label><br>';
echo '<label>国家：<input type="text" name="country" value="' . $row["Country"] . '"></label><br>';
echo '<label>语言：<input type="text" name="language" value="' . $row["Language"] . '"></label><br>';
echo '<label>上映时间：<input type="text" name="releasetime" value="' . $row["ReleaseTime"] . '"></label><br>';
echo '<input type="submit" value="保存修改">';
echo '</form>';

// 关闭数据库连接
mysqli_close($conn);
?>