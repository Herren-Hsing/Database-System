<?php
// 建立数据库连接
include("connect.php");

// 开始事务
$conn->begin_transaction();

// 构建删除操作的SQL查询语句
$movieID = $_GET['movieid'];
$sql = "DELETE FROM movie WHERE movieid = '$movieID'";

// 执行删除操作
if ($conn->query($sql) === TRUE) {
    // 删除成功
    echo '<script>alert("电影删除成功");</script>';
    $conn->commit(); // 提交事务
} else {
    // 删除失败
    echo "电影删除失败：" . $conn->error;
    $conn->rollback(); // 回滚事务
}
echo '<script>window.location.href = "moviemanage.php";</script>';
// 关闭数据库连接
$conn->close();
?>