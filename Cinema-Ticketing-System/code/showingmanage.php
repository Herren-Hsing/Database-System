<!DOCTYPE html>
<html>

<head>
    <title>电影场次管理</title>
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
            text-align: center;
        }

        form input[type="datetime-local"] {
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
            text-align: center;
        }

        /* 标签样式 */
        label {
            display: inline-block;
            margin-bottom: 8px;
            margin-top: 8px;
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
</head>

<body>
    <div class="container">
        <form method="get">
            <input type="text" name="name" style="width:50%;" placeholder="搜索电影名称...">
            <button type="submit" class="filter-button">搜索</button>
        </form>
        <button id="showPopup" onclick="showPopup()" class="new-button">添加新场次</button>
        <button id="showPopup" onclick="redirectToShowingManage()" class="new-button">返回前页</button>
        <form id="myForm" method="post" action='updateshowing.php'
            style="border-radius: 10px;text-align: center; box-shadow: 0px 0px 10px grey;display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; ">
            <label for="showingid">放映ID</label>
            <input type="text" id="showingid" name="showingid"><br>
            <label for="movieid">电影ID</label>
            <input type="text" id="movieid" name="movieid"><br>
            <label for="roomid">放映厅ID</label>
            <input type="text" id="roomid" name="roomid"><br>
            <label for="seatsremained">座位余量</label>
            <input type="text" id="seatsremained" name="seatsremained"><br>
            <label for="price">票价</label>
            <input type="text" id="price" name="price"><br>
            <label for="starttime">开始时间</label>
            <input type="datetime-local" id="starttime" name="starttime"><br>
            <label for="endtime">结束时间</label>
            <input type="datetime-local" id="endtime" name="endtime"><br>
            <button type="submit">添加</button>
            <button type="button" onclick="closeForm()">关闭</button>
        </form>

    </div>
    <script>
        function redirectToShowingManage() {
            window.location.href = "moviemanage.php";
        }
    </script>
    <table>
        <thead>
            <tr>
            <th>场次ID</th>
                <th>电影ID</th>
                <th>电影名称</th>
                <th>电影院ID</th>
                <th>电影院名称</th>
                <th>放映厅ID</th>
                <th>放映厅名称</th>
                <th>开始时间</th>
                <th>结束时间</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 连接数据库
            include("connect.php");

            // 查询电影信息
            $sql = "select showingid,movieid,moviename,cinemaid,cinemaname,roomid,roomname,showingid,starttime,endtime  
            from showing natural join movie natural join screeningroom natural join cinemas  where 1=1";
            if (isset($_GET['name'])) {
                $name = $_GET['name'];
                $sql .= " AND moviename LIKE '%$name%'";
            }
            $sql .= " order BY MovieID";
            $result = $conn->query($sql);

            // 输出表格
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["showingid"] . "</td>";
                    echo "<td>" . $row["movieid"] . "</td>";
                    echo "<td>" . $row["moviename"] . "</td>";
                    echo "<td>" . $row["cinemaid"] . "</td>";
                    echo "<td>" . $row["cinemaname"] . "</td>";
                    echo "<td>" . $row["roomid"] . "</td>";
                    echo "<td>" . $row["roomname"] . "</td>";
                    echo "<td>" . $row["starttime"] . "</td>";
                    echo "<td>" . $row["endtime"] . "</td>";
                    echo "</tr>";
                }
            }
            if (isset($_GET['name'])) {
                $name = $_GET['name'];
                $sql .= " AND m.MovieName LIKE '%$name%'";
            }

            // 断开数据库连接
            mysqli_close($conn);
            ?>

        </tbody>
    </table>

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