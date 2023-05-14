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

        #submit {
            background-color: #4CAF50;
            color: white;
        }

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
    <h1 class="h1-style">正在热映</h1>
</head>

<body>
    <div class="container">
        <form method="get">
            <input type="text" name="name" style="width:50%;" placeholder="搜索电影名称...">
            <button type="submit" class="filter-button">搜索</button>
        </form>
        <button id="showPopup" onclick="redirectToTicket('<?php echo $_GET['userid']; ?>')"
            class="new-button">我的订单</button>
        <button id="showPopup" onclick="redirectToCenter('<?php echo $_GET['userid']; ?>')"
            class="new-button">个人中心</button>
        <button id="showPopup" onclick="redirectToIndex()" class="new-button">退出登录</button>

        <script>
            function redirectToIndex() {
                window.location.href = "index.html";
            }
            function redirectToCenter(userid) {
                window.location.href = "information.php?userid=" + userid;
            }
            function redirectToTicket(userid) {
                window.location.href = "myticket.php?userid=" + userid;
            }
        </script>

    </div>
    <table>
        <thead>
            <tr>
                <th>电影名称</th>
                <th>时长</th>
                <th>国家</th>
                <th>语言</th>
                <th>类型</th>
                <th>场次数</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 连接数据库
            include("connect.php");

            // 查询电影信息
            $sql = "SELECT * FROM movie_info_view WHERE 1=1";

            if (isset($_GET['name'])) {
                $name = $_GET['name'];
                $sql .= " AND moviename LIKE '%$name%'";
            }

            $result = $conn->query($sql);
            // 输出表格
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["moviename"] . "</td>";
                    echo "<td>" . $row["duration"] . "</td>";
                    echo "<td>" . $row["country"] . "</td>";
                    echo "<td>" . $row["language"] . "</td>";
                    echo "<td>" . $row["types"] . "</td>";
                    echo "<td>" . $row["showingcount"] . "</td>";
                    echo "<td>
                    <button class='filter-button' onclick=\"chooseshowing('" . $row['movieid'] . "', '" . $_GET['userid'] . "')\">查看场次</button>
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
        function chooseshowing(movieId, userId) {
            window.location.href = "chooseshowing.php?movieid=" + movieId + "&userid=" + userId;
        }
    </script>

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