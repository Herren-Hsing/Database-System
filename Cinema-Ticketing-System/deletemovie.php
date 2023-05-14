<?php
// 建立数据库连接
include("connect.php");

// 开始事务
$conn->begin_transaction();

// 删除操作的SQL语句
$movieID = $_GET['movieid'];
$sql = "delete from movie where movieid = '$movieID'";

// 执行删除操作
if ($conn->query($sql)) {
    // 删除成功
    echo '<script>alert("电影删除成功");</script>';
    $conn->commit(); // 提交事务
} else {
    // 删除失败
    echo '<script>alert("电影删除失败");</script>';
    $conn->rollback(); // 回滚事务
}

// 跳转至电影信息管理页面
echo '<script>window.location.href = "moviemanage.php";</script>';

// 关闭数据库连接
$conn->close();
?>