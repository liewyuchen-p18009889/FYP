<!doctype html>
<html lang="en">

<head>
    <!--using external files-->
    <?php 
        ob_start(); //to solve errors of "Cannot modify header information - headers already sent"
        session_start();
        include 'import.html';
     ?>

    <!-- Side Menu Bar Style CSS -->
    <link rel="stylesheet" href="/FYP/sideMenuBarStyle.css">
    <style>
        .swal-text {
            text-align: center;
        }

        .swal-footer {
            text-align: center;
        }
    </style>

    <title>UTask | Dashboard</title>
</head>

<body class="bg-light">
    <?php include 'header.php'; 
    
        // check if user is the project's member so that can access to the project's dashboard START
        $query1 = "SELECT * FROM project_members WHERE user_id={$_SESSION['user_id']} AND project_id={$_GET['id']}";
        $runQuery1 = mysqli_query($dbc, $query1);
        $countQuery1 = mysqli_num_rows($runQuery1);
        
        if($countQuery1 == 0){
            echo '<script language="javascript">
                    alert("Invalid URL!");
                    window.location.href="/FYP/projectList.php";
                    </script>';
        }
        // check if user is the project member so that can access to the project's dashboard END
    ?>
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-6 pl-0">
                <h3 class="text-info"><span style="cursor:pointer" onclick="openNav()"><i class="fas fa-bars"></i></span> Dashboard</h3>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <?php
                    // check if empty task then no show generate report button START
                    $query7 = "SELECT * FROM tasks WHERE task_project={$_GET['id']}";
                    $runQuery7 = mysqli_query($dbc, $query7);
                    $countQuery7 = mysqli_num_rows($runQuery7);

                    if($countQuery7 > 0){
                        ?>
                        <form action="/FYP/generateReport.php" method="post">
                            <input type="hidden" name="get_projectID" value="<?php echo $_GET['id']; ?>">
                            <button type="submit" class="btn btn-info" name="btnGeneratePDF">
                                <i class="fas fa-file-pdf p-1" style="font-size: 20px;"></i>&nbsp;Generate Report
                            </button>
                        </form>
                        <?php
                    }
                    // check if empty task then no show generate report button END
                ?>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="card-deck ml-3 mr-3 mb-5">
            <!-- total tasks START -->
            <div class="card shadow border-info">
                <div class="card-body">
                    <h2 class="card-text text-center">Total</h2>
                    <h1 class="card-text text-center text-info"><span class="counter">
                            <?php 
                            $query2 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}'";
                            $runQuery2 = mysqli_query($dbc, $query2);
                            $countTotal = mysqli_num_rows($runQuery2);

                            echo $countTotal; 
                        ?>
                        </span></h1>
                </div>
            </div>
            <!-- total tasks END -->
            <!-- in progress tasks START -->
            <div class="card shadow border-primary">
                <div class="card-body">
                    <h2 class="card-text text-center">In progress</h2>
                    <h1 class="card-text text-center text-primary"><span class="counter">
                            <?php 
                            $query3 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' AND task_status='In Progress'";
                            $runQuery3 = mysqli_query($dbc, $query3);
                            $countInProgress = mysqli_num_rows($runQuery3);

                            echo $countInProgress;
                        ?>
                        </span></h1>
                </div>
            </div>
            <!-- in progress tasks END -->
            <!-- completed tasks START -->
            <div class="card shadow border-success">
                <div class="card-body">
                    <h2 class="card-text text-center">Completed</h2>
                    <h1 class="card-text text-center text-success"><span class="counter">
                            <?php 
                            $query4 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' AND task_status='Done'";
                            $runQuery4 = mysqli_query($dbc, $query4);
                            $countDone = mysqli_num_rows($runQuery4);

                            echo $countDone;
                        ?>
                        </span></h1>
                </div>
            </div>
            <!-- completed tasks END -->
            <!-- overdue tasks START -->
            <div class="card shadow border-danger">
                <div class="card-body">
                    <h2 class="card-text text-center">Overdue</h2>
                    <h1 class="card-text text-center text-danger"><span class="counter">
                            <?php 
                            $query5 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' AND task_status!='Done'";
                            $runQuery5 = mysqli_query($dbc, $query5);
                            $todayDate = date("Y-m-d");
                            $countOverdue = 0;
                            
                            foreach($runQuery5 as $row5){
                                if($todayDate > $row5['task_end']){
                                    $countOverdue++;
                                }
                            }
                            echo $countOverdue;
                        ?>
                        </span></h1>
                </div>
            </div>
            <!-- overdue tasks END -->
        </div>
        <div class="row d-flex justify-content-center">
            <!-- <div class="col-3 shadow p-4 mb-5 mr-3 bg-white rounded"></div>
            <div class="col-3 shadow p-4 mb-5 bg-white rounded"></div>
            <div class="col-5 shadow p-4 mb-5 ml-3 bg-white rounded"><h5 class="text-info">Activity</h5></div> -->

            <?php 
                $query5 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' AND task_status='To Do'";
                $runQuery5 = mysqli_query($dbc, $query5);
                $countToDo = mysqli_num_rows($runQuery5);

                $query6 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' AND task_status='Test'";
                $runQuery6 = mysqli_query($dbc, $query6);
                $countTest = mysqli_num_rows($runQuery6);
            ?>

            <!-- pass value to chart.js START -->
            <input type="hidden" id="count_toDo" value="<?php echo $countToDo; ?>">
            <input type="hidden" id="count_inProgress" value="<?php echo $countInProgress; ?>">
            <input type="hidden" id="count_test" value="<?php echo $countTest; ?>">
            <input type="hidden" id="count_done" value="<?php echo $countDone; ?>">
            <input type="hidden" id="count_overdue" value="<?php echo $countOverdue; ?>">
            <!-- pass value to chart.js END -->

            <div class="col-md-7 col-sm-12 shadow p-4 mb-5 mr-md-3 bg-white rounded">
                <h4 class="text-info">Project Status</h4>
                <canvas id="myChart" width="100" height="55"></canvas>
            </div>
            <div class="col-md-4 col-sm-12 shadow p-4 mb-5 ml-md-3 bg-white rounded">
                <h4 class="text-info">Task Status</h4>
                <canvas id="myChart2" width="" height=""></canvas>
            </div>
        </div>
    </div>
    <?php include 'sideMenuBar.php'; ?>
    <?php include 'footer.html'; ?>
    <!-- bar chart START -->
    <script>
        var countToDo = $('#count_toDo').val();
        var countInProgress = $('#count_inProgress').val();
        var countTest = $('#count_test').val();
        var countDone = $('#count_done').val();
        var countOverdue = $('#count_overdue').val();

        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['To Do', 'In Progress', 'Test', 'Done'],
                datasets: [{
                    data: [countToDo, countInProgress, countTest, countDone],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
    <!-- bar chart END -->
    <!-- pie chart START -->
    <script>
        var ctx2 = document.getElementById('myChart2');

        var myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: [
                    'In Progress',
                    'Completed',
                    'Overdue'
                ],
                datasets: [{
                    label: 'My First Dataset',
                    data: [countInProgress, countDone, countOverdue],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    </script>
    <!-- pie chart END -->
    <!-- counter animation START -->
    <script>
        $('.counter').each(function () {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 1500,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    </script>
    <!-- counter animation END -->
</body>

</html>