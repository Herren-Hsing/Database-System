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
            text-align: center;
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
            text-align: center;
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

        <button id="showPopup" onclick="redirectToIndex(<?php echo $_GET['userid']; ?>)"
            class="new-button">返回前页</button>
        <script>
            function redirectToIndex(userid) {
                window.location.href = "choosemovie.php?userid=" + userid;
            }
        </script>
    </div>
    <table>
        <thead>
            <tr>
                <th>订单ID</th>
                <th>场次ID</th>
                <th>电影名称</th>
                <th>影院名称</th>
                <th>放映厅名称</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>订单状态</th>
                <th>座位行序</th>
                <th>座位列序</th>
                <th>操作</th> <!-- 新添加的列 -->
            </tr>
        </thead>
        <tbody>
            <?php
            // 连接数据库
            include("connect.php");

            $userid = $_GET['userid'];

            // 查询电影信息
            $sql = "SELECT 
            t.ticketid,
            s.showingid,
            IFNULL(m.MovieName, '') AS moviename,
            IFNULL(c.CinemaName, '') AS cinemaname,
            IFNULL(sr.RoomName, '') AS roomname,
            s.StartTime,
            s.EndTime,
            t.TicketStatus,
            IFNULL(st.SeatRow, '') AS seatrow,
            IFNULL(st.SeatColumn, '') AS seatcolumn
          FROM ticket t
          LEFT JOIN showing s ON t.ShowingID = s.ShowingID
          LEFT JOIN movie m ON s.MovieID = m.MovieID
          LEFT JOIN screeningroom sr ON s.RoomID = sr.RoomID
          LEFT JOIN seat st ON t.SEATID = st.SeatID
          LEFT JOIN cinemas c ON sr.CinemaID = c.CinemaID
          where userid=$userid;               
        ";

            $result = $conn->query($sql);

            // 输出表格
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ticketid"] . "</td>";
                    echo "<td>" . $row["showingid"] . "</td>";
                    echo "<td>" . $row["moviename"] . "</td>";
                    echo "<td>" . $row["cinemaname"] . "</td>";
                    echo "<td>" . $row["roomname"] . "</td>";
                    echo "<td>" . $row["StartTime"] . "</td>";
                    echo "<td>" . $row["EndTime"] . "</td>";
                    echo "<td>" . $row["TicketStatus"] . "</td>";
                    echo "<td>" . $row["seatrow"] . "</td>";
                    echo "<td>" . $row["seatcolumn"] . "</td>";

                    // 根据订单状态显示不同的按钮
                    echo "<td>";
                    if ($row["TicketStatus"] == "待退款") {
                        echo "<button  class='filter-button'>点击退款</button>";
                    } else {
                        echo "<form method='POST' action='updateticket.php'>";
                        echo "<input type='hidden' name='ticketid' value='" . $row["ticketid"] . "'>";
                        echo "<input type='hidden' name='userid' value=$userid>";
                        echo "<button type='submit' class='filter-button s'>修改订单</button>";
                        echo "</form>";
                    }
                    echo "</td>";

                    echo "</tr>";
                }
            }
            // 断开数据库连接
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>

</html>