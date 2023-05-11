<!DOCTYPE html>
<html>

<head>
    <title>电影信息表格</title>
    <style>
        .container {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
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
</head>

<body>
    <div class="container">
        <form method="get">
            <input type="text" name="name" style="width:50%;" placeholder="搜索电影名称...">
            <button type="submit" class="filter-button">搜索</button>
            <label for="movie-type-select">电影类型筛选：</label>
            <select id="movie-type-select" name="type">

                <option value="全部">全部</option>
                <?php
                // 连接数据库
                include("connect.php");

                // 查询所有电影类型
                $sql = "SELECT DISTINCT MovieTypeName FROM havetype";
                $result = $conn->query($sql);

                // 输出下拉菜单选项
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = "";
                        if (isset($_GET['type']) && $_GET['type'] == $row['MovieTypeName']) {
                            $selected = "selected";
                        }
                        echo '<option value="' . $row['MovieTypeName'] . '" ' . $selected . '>' . $row['MovieTypeName'] . '</option>';
                    }
                }

                // 断开数据库连接
                mysqli_close($conn);
                ?>
            </select>

        </form>
        <button id="showPopup" onclick="showPopup()" class="new-button">添加新电影</button>

        <form id="myForm" method="post" action='update_movie.php'
            style="border-radius: 10px;text-align: center; box-shadow: 0px 0px 10px grey;display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; ">
            <label for="id">电影ID</label>
            <input type="text" id="id" name="id"><br>
            <label for="name">电影名称</label>
            <input type="text" id="name" name="name"><br>
            <label for="duration">时长</label>
            <input type="text" id="duration" name="duration"><br>
            <label for="country">国家</label>
            <input type="text" id="country" name="country"><br>
            <label for="language">语言</label>
            <input type="text" id="language" name="language"><br>
            <label for="release_date">上映时间</label>
            <input type="date" id="release_date" name="release_date"><br>
            <button type="submit">提交</button>添加
            <button type="button" onclick="closeForm()">关闭</button>
        </form>
        <button id="showPopup" onclick="redirectToShowingManage()" class="new-button">电影场次管理</button>
        <button id="showPopup" onclick="redirectToTicket()" class="new-button">订单管理</button>
        <button id="showPopup" onclick="redirectToIndex()" class="new-button">返回首页</button>
        <script>
            function redirectToShowingManage() {
                window.location.href = "showingmanage.php";
            }
            function redirectToTicket() {
                window.location.href = "ticketmanage.php";
            }
            function redirectToIndex() {
                window.location.href = "index.html";
            }
        </script>

    </div>
    <table>
        <thead>
            <tr>
                <th>电影ID</th>
                <th>电影名称</th>
                <th>时长</th>
                <th>国家</th>
                <th>语言</th>
                <th>类型</th>
                <th>上映时间</th>
                <th>场次数</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 连接数据库
            include("connect.php");

            // 查询电影信息
            $sql = "SELECT m.movieid, m.MovieName, m.Duration, m.Country, m.Language, GROUP_CONCAT(DISTINCT ht.MovieTypeName) AS Types, m.ReleaseTime, COUNT(distinct s.showingid) AS ShowingCount
            FROM Movie m
            LEFT JOIN (SELECT DISTINCT MovieID, MovieTypeName FROM havetype) ht ON m.MovieID = ht.MovieID
            LEFT JOIN showing s ON m.MovieID = s.MovieID
                WHERE 1=1";

            // 根据筛选条件生成SQL语句
            if (isset($_GET['type'])) {
                $type = $_GET['type'];
                if ($type == '全部') {

                } else {
                    $sql .= " AND ht.MovieID IN (SELECT movieid FROM havetype s WHERE s.MovieTypeName = '$type')";
                }
            }

            if (isset($_GET['name'])) {
                $name = $_GET['name'];
                $sql .= " AND m.MovieName LIKE '%$name%'";
            }

            $sql .= " GROUP BY m.MovieID";

            $result = $conn->query($sql);

            // 输出表格
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["movieid"] . "</td>";
                    echo "<td>" . $row["MovieName"] . "</td>";
                    echo "<td>" . $row["Duration"] . "</td>";
                    echo "<td>" . $row["Country"] . "</td>";
                    echo "<td>" . $row["Language"] . "</td>";
                    echo "<td>" . $row["Types"] . "</td>";
                    echo "<td>" . $row["ReleaseTime"] . "</td>";
                    echo "<td>" . $row["ShowingCount"] . "</td>";
                    echo "<td>
                    <button class='filter-button' onclick=\"window.location.href='updatemovieinfo.php?movieid=" . $row['movieid'] . "'\">修改</button>

                    <button class='filter-button' onclick=\"deleteMovie('" . $row['movieid'] . "')\">删除</button>
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
    function deleteMovie(movieId) {
        if (confirm("确定要删除该电影吗？")) {
            window.location.href = "deletemovie.php?movieid=" + movieId;
        }
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