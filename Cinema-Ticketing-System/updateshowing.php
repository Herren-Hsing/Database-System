<?php
//连接数据库
$conn = mysqli_connect('localhost:3306', 'root', 'root');

//如果连接数据库失败就输出错误信息
if (!$conn) {
    die("连接数据库错误：" . mysqli_error($conn));
}

//选择数据库
mysqli_select_db($conn, 'cinema');

//选择字符集
mysqli_set_charset($conn, 'utf8');
$showingid = $_POST['showingid'];
$movieid = $_POST['movieid'];
$roomid = $_POST['roomid'];
$seatsremained = $_POST['seatsremained'];
$price = $_POST['price'];
$starttime = $_POST['starttime'];
$endtime = $_POST['endtime'];

// 检查数据完整性
if (empty($showingid) || empty($movieid) || empty($roomid) || empty($seatsremained) || empty($price) || empty($starttime) || empty($endtime)) {
    echo "<script>alert('请填写所有字段！');</script>";
}

// 验证movieid和price为数字
if (!is_numeric($movieid) || !is_numeric($price)) {
    echo "<script>alert('电影ID和票价必须为数字！');</script>";
}

// 转换日期时间格式
$starttime = date('Y-m-d H:i:s', strtotime($starttime));
$endtime = date('Y-m-d H:i:s', strtotime($endtime));

$sql = "INSERT INTO showing (showingid, movieid, roomid, seatsremained, price, starttime, endtime) 
        VALUES ('$showingid', '$movieid', '$roomid', '$seatsremained', '$price', '$starttime', '$endtime')";

try {
    // 执行插入语句
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('数据插入成功！');</script>";
    } else {
        echo "<script>alert('数据插入失败：" . $conn->error . "');</script>";
    }
} catch (mysqli_sql_exception $e) {
    echo "<script>alert('数据插入失败：" . $e->getMessage() . "');</script>";
}

echo "<script>url = \"moviemanage.php?\"; window.location.href = url;</script>";

$conn->close();
?>