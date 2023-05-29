<?php
include("connect.php");

// 获取COOKIE中的movieid
$movieid = $_GET['movieid'];

// 检索电影信息
$sql = "SELECT * FROM movie WHERE MovieID = $movieid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出数据
    while ($row = $result->fetch_assoc()) {
        $movieName = $row["MovieName"];
        $duration = $row["Duration"];
        $country = $row["Country"];
        $language = $row["Language"];
        $releaseTime = $row["ReleaseTime"];
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>电影信息</title>
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
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            font-family: Arial, sans-serif;
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
        <h1>电影信息</h1>
        <div class="center">
            <form method="post" action="updatemovie.php">
                <input type="hidden" id="movieid" name="movieid" value="<?php echo $movieid; ?>">
                <label for="moviename">电影名称</label>
                <input type="text" id="moviename" name="moviename" value="<?php echo $movieName; ?>">
                <label for="duration">时长</label>
                <input type="text" id="duration" name="duration" value="<?php echo $duration; ?>">
                <label for="country">国家</label>
                <input type="text" id="country" name="country" value="<?php echo $country; ?>">

                <label for="language">语言</label>
                <input type="text" id="language" name="language" value="<?php echo $language; ?>">
                <label for="releasetime">上映时间</label>
                <input type="date" id="releasetime" name="releasetime" value="<?php echo $releaseTime; ?>">
                <br>
                <input type="submit" value="保存">
            </form>
            <form>
                <button class="return-button">返回</button>
            </form>
        </div>
    </div>
    </div>
</body>

</html>