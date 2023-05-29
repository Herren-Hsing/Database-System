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

if (!empty($_POST["duration"]) && is_numeric($_POST["duration"])) {
    $duration = mysqli_real_escape_string($conn, $_POST["duration"]);
} else {
    $duration = 0;
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
$sql = "INSERT INTO movie (MovieID, MovieName, Duration, Country, Language, ReleaseTime)
VALUES ('$movieid', '$moviename', '$duration', '$country', '$language', '$releasetime');
";

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