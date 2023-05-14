<?php
$host = 'localhost:3306';  // MySQL 服务器地址
$username = 'root';        // 数据库用户名
$password = 'root';        // 数据库密码
$database = 'cinema';      // 数据库名称

// 创建数据库连接
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
	die("连接数据库错误：" . mysqli_error($conn));
}

//选择字符集
mysqli_set_charset($conn, 'utf8');
?>