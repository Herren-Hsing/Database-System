<!DOCTYPE html>
<html>

<head>
    <title>订单管理</title>
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

        <button id="showPopup" onclick="redirectToShowingManage()" class="new-button">返回前页</button>

        <script>
            function redirectToShowingManage() {
                window.location.href = "moviemanage.php";
            }
        </script>

    </div>
    <table>
        <thead>
            <tr>
                <th>订单ID</th>
                <th>场次ID</th>
                <th>电影ID</th>
                <th>用户ID</th>
                <th>购买时间</th>
                <th>订单状态</th>
                <th>座位ID</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 连接数据库
            include("connect.php");

            // 查询电影信息
            $sql = "SELECT ticketid,IFNULL(t.showingid, 'NULL') AS showingid,IFNULL(movieid, 'NULL') AS movieid,userid,purchasetime,ticketstatus,IFNULL(seatid, 'NULL') AS seatid
            FROM ticket t
            LEFT JOIN showing s ON t.showingid = s.showingid;            
            ";

            $result = $conn->query($sql);

            // 输出表格
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ticketid"] . "</td>";
                    echo "<td>" . $row["showingid"] . "</td>";
                    echo "<td>" . $row["movieid"] . "</td>";
                    echo "<td>" . $row["userid"] . "</td>";
                    echo "<td>" . $row["purchasetime"] . "</td>";
                    echo "<td>" . $row["ticketstatus"] . "</td>";
                    echo "<td>" . $row["seatid"] . "</td>";
                    echo "</tr>";
                }
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
</body>

</html>