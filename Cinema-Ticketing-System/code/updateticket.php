<?php
include("connect.php");

$ticketid = $_POST['ticketid'];
$userid = $_POST['userid'];

$sql = "SELECT m.MovieName,t.ShowingID
FROM ticket t
JOIN showing s ON t.ShowingID = s.ShowingID
JOIN movie m ON s.MovieID = m.MovieID
WHERE t.ticketid = '$ticketid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出数据
    while ($row = $result->fetch_assoc()) {
        $moviename = $row["MovieName"];
        $showingid = $row["ShowingID"];
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
            width: 450px;
        }


        .login-container h1 {
            font-size: 36px;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
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

        .form-row {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .form-row label {
            flex: 0 0 auto;
            text-align: center;
            margin-right: 10px;
        }

        .button-row {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button-row input[type="submit"],
        .button-row button.return-button {
            margin: 0 5px;
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

        .form-row select {
            width: 320px;
        }

        .form-row input {
            width: 320px;
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
        <h1>修改订单</h1>
        <div class="center">
            <form method="post" action="upticket.php">
                <input type="hidden" id="ticketid" name="ticketid" value="<?php echo $ticketid; ?>">
                <input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>">
                <div class="form-row">
                    <label for="moviename">电影名称</label>
                    <select id="moviename" name="moviename" onchange="filterCinemas();filterShowing();">
                        <option value="NULL">请选择电影名称</option>
                        <?php
                        // 连接到数据库
                        include("connect.php");

                        $sql = "SELECT DISTINCT moviename, movieid FROM movie NATURAL JOIN showing";
                        $result = $conn->query($sql);

                        // 将查询结果添加到下拉菜单的选项中
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["movieid"] . "'>" . $row["moviename"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>没有找到电影名称</option>";
                        }
                        // 关闭数据库连接
                        $conn->close();
                        ?>
                    </select>
                </div>
                <div class="form-row">
                    <label for="cinemaname">影院名称</label>
                    <select id="cinemaname" name="cinemaname" onchange="filterCinemas();filterShowing();">
                        <option value="NULL">请选择电影院名称</option>
                        <?php
                        include("connect.php");

                        $sql = "SELECT DISTINCT cinemaname,cinemaid,movieid FROM cinemas NATURAL JOIN screeningroom NATURAL JOIN showing NATURAL JOIN movie";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["cinemaid"] . "' data-cinemaname='" . $row["cinemaname"] . "' data-movieid='" . $row["movieid"] . "'>" . $row["cinemaname"] . "</option>";
                            }
                        } else {
                            echo "<option value='NULL'>没有找到电影院名称</option>";
                        }

                        $conn->close();
                        ?>
                    </select>
                    <script>
                        function filterCinemas() {
                            var movieId = document.getElementById("moviename").value;
                            var cinemas = document.querySelectorAll("#cinemaname option");

                            for (var i = 0; i < cinemas.length; i++) {
                                if (cinemas[i].getAttribute("data-movieid") === movieId || movieId === "") {
                                    cinemas[i].style.display = "block";
                                } else {
                                    cinemas[i].style.display = "none";
                                }
                            }
                        }
                    </script>
                </div>
                <div class="form-row">
                    <label for="showingid">场次ID</label>

                    <select id="showingid" name="showingid"
                        onchange="filterRoom();filterStart();filterEnd();filterRow();">
                        <option value="NULL">请选择场次ID以查看详细信息</option>

                        <?php
                        include("connect.php");

                        $sql = "SELECT DISTINCT showingid,movieid,cinemaid  FROM movie natural join showing natural join screeningroom natural join cinemas";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["showingid"] . "' data-movieid='" . $row["movieid"] . "' data-cinemaid='" . $row["cinemaid"] . "'>" . $row["showingid"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>没有找到场次ID</option>";
                        }

                        $conn->close();
                        ?>
                    </select>

                    <script>
                        function filterShowing() {
                            var movieId = document.getElementById("moviename").value;
                            var cinemaId = document.getElementById("cinemaname").value;
                            var showing = document.querySelectorAll("#showingid option");

                            for (var i = 0; i < showing.length; i++) {
                                if ((showing[i].getAttribute("data-movieid") === movieId || movieId === "") && showing[i].getAttribute("data-cinemaid") === cinemaId) {
                                    showing[i].style.display = "block";
                                } else {
                                    showing[i].style.display = "none";
                                }
                            }
                        }
                    </script>
                </div>
                <div class="form-row">

                    <label for="screeningroom">影厅名称</label>
                    <input type="text" id="screeningroom" name="screeningroom" disabled>
                    <?php
                    include("connect.php");

                    $sql = "SELECT DISTINCT roomname,showingid FROM showing NATURAL JOIN screeningroom";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<datalist id='roomname'>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["roomname"] . "' data-showingid='" . $row["showingid"] . "'>" . $row["roomname"] . "</option>";
                        }
                        echo "</datalist>";
                    } else {
                        echo "<datalist id='roomname'><option value=''>没有找到放映厅ID</option></datalist>";
                    }

                    $conn->close();
                    ?>
                    <script>
                        function filterRoom() {
                            var showingid = document.getElementById("showingid").value;
                            var roomnameInput = document.getElementById("screeningroom");
                            var roomnameOptions = document.querySelectorAll("#roomname option");
                            var uniqueRoomname = "";

                            for (var i = 0; i < roomnameOptions.length; i++) {
                                if (roomnameOptions[i].getAttribute("data-showingid") === showingid || showingid === "") {
                                    roomnameOptions[i].style.display = "block";
                                    uniqueRoomname = roomnameOptions[i].value;
                                } else {
                                    roomnameOptions[i].style.display = "none";
                                }
                            }

                            roomnameInput.value = uniqueRoomname;
                        }
                    </script>
                </div>
                <div class="form-row">

                    <label for="starttime">开始时间</label>
                    <input type="text" id="starttime" name="starttime" disabled>
                    <?php
                    include("connect.php");

                    $sql = "SELECT DISTINCT starttime,showingid FROM showing";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<datalist id='starttime'>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["starttime"] . "' data-showingid='" . $row["showingid"] . "'>" . $row["starttime"] . "</option>";
                        }
                        echo "</datalist>";
                    } else {
                        echo "<datalist id='starttime'><option value=''>没有找到开始时间</option></datalist>";
                    }

                    $conn->close();
                    ?>
                    <script>
                        function filterStart() {
                            var showingid = document.getElementById("showingid").value;
                            var starttimeInput = document.getElementById("starttime");
                            var starttimeOptions = document.querySelectorAll("#starttime option");
                            var uniqueStarttime = "";

                            for (var i = 0; i < starttimeOptions.length; i++) {
                                if (starttimeOptions[i].getAttribute("data-showingid") === showingid || showingid === "") {
                                    starttimeOptions[i].style.display = "block";
                                    uniqueStarttime = starttimeOptions[i].value;
                                } else {
                                    starttimeOptions[i].style.display = "none";
                                }
                            }

                            starttimeInput.value = uniqueStarttime;
                        }
                    </script>
                </div>
                <div class="form-row">

                    <label for="endtime">结束时间</label>
                    <input type="text" id="endtime" name="endtime" disabled>
                    <?php
                    include("connect.php");

                    $sql = "SELECT DISTINCT endtime,showingid FROM showing";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<datalist id='endtime'>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["endtime"] . "' data-showingid='" . $row["showingid"] . "'>" . $row["endtime"] . "</option>";
                        }
                        echo "</datalist>";
                    } else {
                        echo "<datalist id='endtime'><option value=''>没有找到开始时间</option></datalist>";
                    }

                    $conn->close();
                    ?>
                    <script>
                        function filterEnd() {
                            var showingid = document.getElementById("showingid").value;
                            var endtimeInput = document.getElementById("endtime");
                            var endtimeOptions = document.querySelectorAll("#endtime option");
                            var uniqueEndtime = "";

                            for (var i = 0; i < endtimeOptions.length; i++) {
                                if (endtimeOptions[i].getAttribute("data-showingid") === showingid || showingid === "") {
                                    endtimeOptions[i].style.display = "block";
                                    uniqueEndtime = endtimeOptions[i].value;
                                } else {
                                    endtimeOptions[i].style.display = "none";
                                }
                            }

                            endtimeInput.value = uniqueEndtime;
                        }
                    </script>
                </div>
                <div class="form-row">

                    <label for="seatrow">座位排号</label>

                    <select id="seatrow" name="seatrow" onchange="filterColumn();">
                        <option value="0">请选择座位排号</option>
                        <?php
                        include("connect.php");

                        $sql = "SELECT DISTINCT seatrow,showingid  FROM showing natural join screeningroom natural join seat";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["seatrow"] . "' data-showingid='" . $row["showingid"] . "'>" . $row["seatrow"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>没有找到座位</option>";
                        }

                        $conn->close();
                        ?>
                    </select>

                    <script>
                        function filterRow() {
                            var showingid = document.getElementById("showingid").value;
                            var showing = document.querySelectorAll("#seatrow option");

                            for (var i = 0; i < showing.length; i++) {
                                if (showing[i].getAttribute("data-showingid") === showingid || showingid === "") {
                                    showing[i].style.display = "block";
                                } else {
                                    showing[i].style.display = "none";
                                }
                            }
                        }
                    </script>
                </div>
                <div class="form-row">

                    <label for="seatcolumn">座位列号</label>

                    <select id="seatcolumn" name="seatcolumn">
                        <option value="0">请选择座位列号</option>
                        <?php
                        include("connect.php");
                        // 还要进行排的限定
                        $sql = "SELECT distinct seatcolumn,seatrow,showingid,status FROM showing NATURAL JOIN seat WHERE status ='not sold'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["seatcolumn"] . "' data-showingid='" . $row["showingid"] . "' data-seatrow='" . $row["seatrow"] . "' data-status='" . $row["status"] . "'>" . $row["seatcolumn"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>没有找到座位</option>";
                        }

                        $conn->close();
                        ?>
                    </select>

                    <script>
                        function filterColumn() {
                            var showingid = document.getElementById("showingid").value;
                            var seatrow = document.getElementById("seatrow").value;
                            var showing = document.querySelectorAll("#seatcolumn option");

                            for (var i = 0; i < showing.length; i++) {
                                var status = showing[i].getAttribute("data-status");
                                if (
                                    (showing[i].getAttribute("data-showingid") === showingid || showingid === "") &&
                                    status === "not sold" && showing[i].getAttribute("data-seatrow") === seatrow
                                ) {
                                    showing[i].style.display = "block";
                                } else {
                                    showing[i].style.display = "none";
                                }
                            }
                        }
                    </script>

                </div>

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