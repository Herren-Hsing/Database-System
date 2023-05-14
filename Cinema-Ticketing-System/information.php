<?php
//连接数据库
include("connect.php");

// 获取COOKIE中的userid
$userid = $_GET["userid"];

// 检索电话号码、生日和座右铭
$sql = "SELECT username,gender,phone, birthday, motto FROM user WHERE userid='$userid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // 输出数据
  while ($row = $result->fetch_assoc()) {
    $username = $row["username"];
    $phone = $row["phone"];
    $birthday = $row["birthday"];
    $motto = $row["motto"];
    $gender = $row["gender"];
  }
  $birthday_str = date("Y-m-d", strtotime($birthday));
} else {
  echo "0 结果";
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>个人信息</title>
  <style>
    body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
    }

    .login-container {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      padding: 50px;
      border-radius: 10px;
      box-shadow: 0px 10px 50px rgba(0, 0, 0, 0.3);
      text-align: center;
      opacity: 0;
      animation: fade-in 0.5s forwards;
      width: 250px;
    }


    .login-container h1 {
      font-size: 36px;
      color: #333;
      text-align: center;
      margin-bottom: 70px;
    }

    .button-container {
      display: inline-block;
      margin-top: 20px;
    }

    .return-button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      width: 120px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 5px;
    }

    label {
      display: block;
      margin-bottom: 10px;
    }

    input[type=text],
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 16px;
    }

    form input[type="date"] {
      width: 100%;
      height: 40px;
      font-size: 16px;
      font-family: Arial, sans-serif;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    input[type=submit] {
      background-color: #4CAF50;
      width: 120px;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
    }

    input[type=submit]:hover {
      background-color: #3e8e41;
    }

    .center {
      text-align: center;
    }

    @keyframes fade-in {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    form label {
      margin-bottom: 10px;
    }

    form label,
    form input,
    form select {
      margin-bottom: 10px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h1>个人信息</h1>
    <div class="center">
      <form method="post" action="update.php">
        <input type="hidden" name="userid" value="<?php echo $userid; ?>">
        <label for="username">用户名:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" disabled>
        <label for="gender">性别:</label>
        <select id="gender" name="gender">
          <option value="secret" <?php if ($gender == 'secret')
            echo 'selected'; ?>>保密</option>
          <option value="male" <?php if ($gender == 'male')
            echo 'selected'; ?>>男</option>
          <option value="female" <?php if ($gender == 'female')
            echo 'selected'; ?>>女</option>
          <option value="intersex" <?php if ($gender == 'intersex')
            echo 'selected'; ?>>双性人</option>
          <option value="gender identity" <?php if ($gender == 'gender identity')
            echo 'selected'; ?>>精神性别</option>
          <option value="non-binary" <?php if ($gender == 'non-binary')
            echo 'selected'; ?>>非二元性别</option>
          <option value="transgender" <?php if ($gender == 'transgender')
            echo 'selected'; ?>>跨性别</option>
          <option value="agender" <?php if ($gender == 'agender')
            echo 'selected'; ?>>无性别</option>
          <option value="bigender" <?php if ($gender == 'bigender')
            echo 'selected'; ?>>两性人</option>
          <option value="trigender" <?php if ($gender == 'trigender')
            echo 'selected'; ?>>三性人</option>
          <option value="genderfluid" <?php if ($gender == 'genderfluid')
            echo 'selected'; ?>>穿越性别</option>
          <option value="transsexual" <?php if ($gender == 'transsexual')
            echo 'selected'; ?>>变性人</option>
          <option value="third gender" <?php if ($gender == 'third gender')
            echo 'selected'; ?>>第三性</option>
          <option value="genderqueer" <?php if ($gender == 'genderqueer')
            echo 'selected'; ?>>无法界定性别</option>
          <option value="multigender" <?php if ($gender == 'multigender')
            echo 'selected'; ?>>多重性别</option>
          <option value="cross-dressing" <?php if ($gender == 'cross-dressing')
            echo 'selected'; ?>>交叉性别</option>
          <option value="transman" <?php if ($gender == 'transman')
            echo 'selected'; ?>>跨性别男性</option>
          <option value="transwoman" <?php if ($gender == 'transwoman')
            echo 'selected'; ?>>跨性别女性</option>
          <option value="graygender" <?php if ($gender == 'graygender')
            echo 'selected'; ?>>灰色地带性别</option>
          <option value="demigender" <?php if ($gender == 'demigender')
            echo 'selected'; ?>>大麻花性别</option>
          <option value="stargender" <?php if ($gender == 'stargender')
            echo 'selected'; ?>>恒星性别</option>
          <option value="awakening gender" <?php if ($gender == 'awakening gender')
            echo 'selected'; ?>>唤醒性别</option>
            <option value="Walmart shopping bags" <?php if ($gender == 'Walmart shopping bags')
            echo 'selected'; ?>>沃尔玛购物袋</option>
          <option value="others" <?php if ($gender == 'others')
            echo 'selected'; ?>>其他</option>
        </select>
        <label for="birthday">生日:</label>
        <input type="date" id="birthday" name="birthday" value="<?php echo $birthday; ?>">
        <label for="phone">手机号:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>">

        <label for="motto">个性签名:</label>
        <input type="text" id="motto" name="motto" value="<?php echo $motto; ?>">
        <br>
        <input type="submit" value="保存">
      </form>
      <button class="return-button" onclick="redirectToChooseMovie()">返回</button>
    </div>
  </div>
  </div>

  <script>
    function redirectToChooseMovie() {
      var userid = "<?php echo $userid; ?>";
      window.location.href = "choosemovie.php?userid=" + userid;
    }
  </script>
</body>

</html>