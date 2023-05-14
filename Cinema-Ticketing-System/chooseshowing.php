<!DOCTYPE html>
<html>

<head>
    <title>正在热映</title>
    <link href="https://fonts.googleapis.com/css2?family=Zhi+Mang+Xing&display=swap" rel="stylesheet">
    <style>
        .h1-style {
            text-align: center;
            font-family: 'Zhi Mang Xing', cursive;
            font-size: 60px;
            font-weight: bold;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            padding: 10px;
            margin: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        input[type=text] {
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
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            font-family: Arial, sans-serif;
            margin-bottom: 10px;
        }

        /* 标签样式 */
        label {
            display: inline-block;
            margin-bottom: 10px;
            margin-top: 10px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }

        .filter-button {
            padding: 6px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            margin-left: 10px;
            display: inline-block;
        }

        .new-button {
            padding: 6px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            display: inline-block;
        }

        button {
            padding: 10px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 0px 5px grey;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        /* 提交按钮样式 */
        #submit {
            background-color: #4CAF50;
            color: white;
        }

        /* 关闭按钮样式 */
        #close {
            background-color: #f44336;
            color: white;
        }

        select {
            padding: 6px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 0px 5px grey;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: inline-block;
            background-color: #4CAF50;
            color: white;
        }
    </style>
    <h1 class="h1-style" id="movie-title">正在热映</h1>

    <?php
    $movieID = $_GET['movieid'];
    include("connect.php");
    $sql = "SELECT moviename FROM movie WHERE movieid = '$movieID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // 输出数据
        $row = $result->fetch_assoc();
        $moviename = $row["moviename"];
    }
    ?>

    <script>
        var movieId = "<?php echo $movieID; ?>";
        var movieName = "<?php echo $moviename; ?>";

        // 这里使用了ES6模板字符串来构建新的文本内容
        var newTitle = `${movieName} 正在热映`;

        // 通过id选择器获取h1元素
        var h1Element = document.getElementById("movie-title");

        // 将新的文本内容赋值给h1元素
        h1Element.textContent = newTitle;
    </script>

</head>

<body>


    <table>
        <thead>
            <tr>
                <th>电影名称</th>
                <th>影院名称</th>
                <th>影院地址</th>
                <th>放映厅</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>座位余量</th>
                <th>票价</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 连接数据库
            include("connect.php");
            // 查询电影信息
            $sql = "SELECT * FROM movie_showing_view WHERE movieid = '{$_GET['movieid']}';";

            $result = $conn->query($sql);
            // 输出表格
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["moviename"] . "</td>";
                    echo "<td>" . $row["cinemaname"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["roomname"] . "</td>";
                    echo "<td>" . $row["starttime"] . "</td>";
                    echo "<td>" . $row["endtime"] . "</td>";
                    echo "<td>" . $row["seatsremained"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td>
                    <button class='filter-button' 
                    onclick=\"newticket('" . $row['movieid'] . "', '" . $_GET['userid'] . "')\">
                    购票</button>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>0 结果</td></tr>";
            }

            // 断开数据库连接
            mysqli_close($conn);
            ?>

        </tbody>
    </table>
    <script>
        function newticket(movieId, userId) {
            window.location.href = "newticket.php?movieid=" + movieId + "&userid=" + userId;
        }
    </script>
    <div class="container">

        <button id="showPopup" onclick="redirectToIndex(<?php echo $_GET['userid']; ?>)"
            class="new-button">返回前页</button>
        <script>
            function redirectToIndex(userid) {
                window.location.href = "choosemovie.php?userid=" + userid;
            }
        </script>
    </div>
    <script>
        const searchInput = document.querySelector('input[type="text"]');
        const searchButton = document.querySelector('button[type="submit"]');
        const form = document.createElement('form');
        form.style.display = 'inline-block';
        form.style.marginLeft = '1em';

        searchInput.parentNode.insertBefore(form, searchInput.nextSibling);
        form.appendChild(searchInput);
        form.appendChild(searchButton);

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const searchValue = searchInput.value.trim();
            const currentUrl = new URL(window.location.href);

            currentUrl.searchParams.set('name', searchValue);
            currentUrl.searchParams.delete('type');

            window.location.href = currentUrl.toString();
        });
        function showPopup() {
            var myForm = document.getElementById("myForm");
            myForm.style.display = "block";
        }
        function closeForm() {
            var myForm = document.getElementById("myForm");
            myForm.style.display = "none";
        }

    </script>
</body>

</html>