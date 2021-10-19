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
    <script type="text/javascript">
        // member status Datatable START
        $(document).ready(function () {
            $('#memberStatusTable').DataTable();
        });
        // member status Datatable END
    </script>
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
    <div class="container-fluid">
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
            <!-- test tasks START -->
            <div class="card shadow border-warning">
                <div class="card-body">
                    <h2 class="card-text text-center">Test</h2>
                    <h1 class="card-text text-center text-warning"><span class="counter">
                        <?php 
                            $query6 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' AND task_status='Test'";
                            $runQuery6 = mysqli_query($dbc, $query6);
                            $countTest = mysqli_num_rows($runQuery6);

                            echo $countTest;
                        ?>
                        </span></h1>
                </div>
            </div>
            <!-- test tasks END -->
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
        </div>
        <div class="row d-flex justify-content-center">
            <!-- <div class="col-3 shadow p-4 mb-5 mr-3 bg-white rounded"></div>
            <div class="col-3 shadow p-4 mb-5 bg-white rounded"></div>
            <div class="col-5 shadow p-4 mb-5 ml-3 bg-white rounded"><h5 class="text-info">Activity</h5></div> -->

            <?php 
                $query5 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' AND task_status='To Do'";
                $runQuery5 = mysqli_query($dbc, $query5);
                $countToDo = mysqli_num_rows($runQuery5);
            ?>

            <!-- pass value to chart.js START -->
            <input type="hidden" id="count_toDo" value="<?php echo $countToDo; ?>">
            <input type="hidden" id="count_inProgress" value="<?php echo $countInProgress; ?>">
            <input type="hidden" id="count_test" value="<?php echo $countTest; ?>">
            <input type="hidden" id="count_done" value="<?php echo $countDone; ?>">
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
    <div class="container-fluid mb-4">
        <div class="card shadow p-4 mb-5 ml-4 mr-4 bg-white rounded" style="min-height: 516px;">
            <h4 class="text-info">Member Status</h4>
            <table id="memberStatusTable" class="table table-hover" style="width:100%;">
                <thead class="bg-light">
                    <tr>
                        <th>Member</th>
                        <th>Total Task</th>
                        <th>To Do</th>
                        <th>In Progress</th>
                        <th>Test</th>
                        <th>Done</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $query8 = "SELECT * FROM project_members
                                    INNER JOIN users ON project_members.user_id=users.user_id
                                    WHERE project_id={$_GET['id']}";
                        $runQuery8 = mysqli_query($dbc, $query8);

                        if($runQuery8){
                            foreach($runQuery8 as $row8){
                                // fetch data of total task for each member
                                $query9 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' 
                                        AND task_asignee='{$row8['user_id']}'";
                                $runQuery9 = mysqli_query($dbc, $query9);
                                $countQuery9 = mysqli_num_rows($runQuery9);

                                // fetch data of to do task for each member
                                $query10 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' 
                                        AND task_asignee='{$row8['user_id']}' AND task_status='To Do'";
                                $runQuery10 = mysqli_query($dbc, $query10);
                                $countQuery10 = mysqli_num_rows($runQuery10);

                                // fetch data of in progress task for each member
                                $query11 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' 
                                        AND task_asignee='{$row8['user_id']}' AND task_status='In Progress'";
                                $runQuery11 = mysqli_query($dbc, $query11);
                                $countQuery11 = mysqli_num_rows($runQuery11);

                                // fetch data of test task for each member
                                $query12 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' 
                                        AND task_asignee='{$row8['user_id']}' AND task_status='Test'";
                                $runQuery12 = mysqli_query($dbc, $query12);
                                $countQuery12 = mysqli_num_rows($runQuery12);

                                // fetch data of done task for each member
                                $query13 = "SELECT * FROM tasks WHERE task_project='{$_GET['id']}' 
                                        AND task_asignee='{$row8['user_id']}' AND task_status='Done'";
                                $runQuery13 = mysqli_query($dbc, $query13);
                                $countQuery13 = mysqli_num_rows($runQuery13);
                                ?>
                            <tr>
                                <td><?php echo $row8['user_name']; ?></td>
                                <td><?php echo $countQuery9; ?></td>
                                <td><?php echo $countQuery10; ?></td>
                                <td><?php echo $countQuery11; ?></td>
                                <td><?php echo $countQuery12; ?></td>
                                <td><?php echo $countQuery13; ?></td>
                            </tr>
                                <?php
                            }
                        }
                    ?> 
                </tbody>
            </table>        
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
                    'Test',
                    'Completed'                    
                ],
                datasets: [{
                    label: 'My First Dataset',
                    data: [countInProgress, countTest, countDone],
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