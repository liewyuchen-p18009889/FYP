<!doctype html>
<html lang="en">

<head>
    <!--using external files-->
    <?php 
        ob_start(); //to solve errors of "Cannot modify header information - headers already sent"
        session_start();
        include 'import.html';
     ?>

    <!-- Style CSS -->
    <link rel="stylesheet" href="/FYP/sideMenuBarStyle.css">
    <style>
        .fc-left {
            color: #17a2b8;
        }

        .fc-time {
            display: none;
        }

        .fc-title {
            color: #f7f7f7;
            font-weight: bold;
        }

        .circle1 {
            height: 25px;
            width: 25px;
            background-color: #95D8EB;
            border-radius: 50%;
        }

        .circle2 {
            height: 25px;
            width: 25px;
            background-color: #4DB4D7;
            border-radius: 50%;
        }

        .circle3 {
            height: 25px;
            width: 25px;
            background-color: #0076BE;
            border-radius: 50%;
        }

        .circle4 {
            height: 25px;
            width: 25px;
            background-color: #2A9DF4;
            border-radius: 50%;
        }
    </style>

    <title>UTask | Calendar</title>

    <script type="text/javascript">
        $(document).ready(function () {
            // var projectID = $('#projectID').val();
            var calendar = $('#calendar').fullCalendar({
                events:
                <?php
                function getEventColor($status) {
                    $eventColor = '';

                    switch ($status) {
                        case 'To Do':
                            $eventColor = '#95D8EB';
                            break;
                        case 'In Progress':
                            $eventColor = '#4DB4D7';
                            break;
                        case 'Test':
                            $eventColor = '#0076BE';
                            break;
                        case 'Done':
                            $eventColor = '#2A9DF4';
                            break;
                    }

                    return $eventColor;
                }

                include 'connectDB.php';
                $data = array();

                $query1 = "SELECT * FROM tasks WHERE task_project={$_GET['id']}";
                $runQuery1 = mysqli_query($dbc, $query1);

                foreach($runQuery1 as $row1) {
                    $data[] = array(
                        'id' => $row1['task_id'],
                        'title' => $row1['task_title'],
                        'start' => $row1['task_start'],
                        'end' => $row1['task_end'],
                        'url' => '/FYP/taskDetails.php?projectID='.$_GET['id'].
                        '&taskID='.$row1['task_id'],
                        'color' => getEventColor($row1['task_status'])
                    );
                }
                echo json_encode($data);
                ?>,
                eventClick: function (event) { //click to redirect to task details
                    console.log("Task ID: " + event.id);
                    console.log("Redirect to: " + event.url);
                }
            });
        });
    </script>
</head>

<body class="bg-light">
    <?php 
        include 'header.php';

        // check if user is the project's member so that can access to the calendar START
        $query2 = "SELECT * FROM project_members WHERE user_id={$_SESSION['user_id']} AND project_id={$_GET['id']}";
        $runQuery2 = mysqli_query($dbc, $query2);
        $countQuery2 = mysqli_num_rows($runQuery2);
        
        if($countQuery2 == 0){
            echo '<script language="javascript">
                    alert("Invalid URL!");
                    window.location.href="/FYP/projectList.php";
                    </script>';
        }
        // check if user is the project member so that can access to the calendar END
    ?>
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-md-6 col-xs-12 p-0">
                <h3 class="text-info"><span style="cursor:pointer" onclick="openNav()"><i
                            class="fas fa-bars"></i></span> Calendar</h3>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <input type="hidden" id="projectID" value="<?php echo $_GET['id']; ?>">
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="card shadow pt-4 pl-5 pr-5 pb-3 mb-5 ml-3 mr-3 bg-white rounded" style="min-height: 516px;">
            <div id="calendar"></div>
            <div class="row mt-1">
                <div class="col-md-3 h5" style='color: #95D8EB;'>&#9632; To Do</div>
                <div class="col-md-3 h5" style='color: #4DB4D7;'>&#9632; In Progress</div>
                <div class="col-md-3 h5" style='color: #0076BE;'>&#9632; Test</div>
                <div class="col-md-3 h5" style='color: #2A9DF4;'>&#9632; Done</div>
            </div> 
        </div>
    </div>
    <?php include 'sideMenuBar.php'; ?>
</body>

</html>