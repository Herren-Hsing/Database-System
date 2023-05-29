<?php
include("connect.php");

$ticketid = $_POST['ticketid'];
$showingid = $_POST['showingid'];
$seatrow = $_POST['seatrow'];
$seatcolumn = $_POST['seatcolumn'];
$userid = $_POST['userid'];

// 创建存储过程调用语句
$sql = "CALL UpdateTicket(\"$ticketid\", \"$showingid\", $seatrow, $seatcolumn, @result);";

// 执行存储过程
$result = $conn->query($sql);

// 获取存储过程的输出结果
$output = $conn->query("SELECT @result AS result")->fetch_assoc();
$p_result = $output['result'];

// 判断调用是否成功
if ($p_result == 'success') {
    echo "<script>alert('订单修改成功');</script>";
} else {
    echo "<script>alert('订单修改失败' + '{$p_result}');</script>";

}
echo "<script>window.location.href = 'myticket.php?userid=' + encodeURIComponent($userid);</script>";


$conn->close();
?>

