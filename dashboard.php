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

    <title>UTask | Dashboard</title>
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-6 pl-0">
                <h3 class="text-info"><span style="cursor:pointer" onclick="openNav()">&#9776;</span> Dashboard</h3>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#addTaskModal"><i
                        class="fas fa-file-pdf" style="font-size: 20px;"></i>&nbsp;Generate Report</button>
            </div>
            <!-- <div class="col-6 d-flex justify-content-end"></div> -->
            <!-- <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-primary" type="button" style="background: #3AAFA9;" data-toggle="modal"
                    data-target="#addProjectModal"><i class="fas fa-plus" style="font-size: 20px;"></i>&nbsp;Create
                    Task</button>
            </div> -->
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="card-deck ml-3 mr-3 mb-5">
            <div class="card shadow border-success">
                <div class="card-body">
                    <!-- <h5 class="card-title text-info">Total Tasks</h5> -->
                    <!-- <h1 class="card-text text-center"><i class="fas fa-tachometer-alt"></i></h1> -->
                    <h2 class="card-text text-center">Total tasks</h2>
                    <h1 class="card-text text-center text-success"><span class="counter">188</span></h1>
                </div>
            </div>
            <div class="card shadow border-primary">
                <div class="card-body">
                    <h2 class="card-text text-center">To do tasks</h2>
                    <h1 class="card-text text-center text-primary"><span class="counter">6</span></h1>
                </div>
            </div>
            <div class="card shadow border-info">
                <div class="card-body">
                    <h2 class="card-text text-center">In progress tasks</h2>
                    <h1 class="card-text text-center text-info"><span class="counter">12</span></h1>
                </div>
            </div>
            <!-- <div class="card shadow border-warning">
                <div class="card-body">
                <h2 class="card-text text-center">Overdue tasks</h2>
                    <h1 class="card-text text-center text-info">6</h1>
                </div>
            </div> -->
        </div>
        <!-- <div class="row d-flex justify-content-center">
            <div class="col-3 shadow p-4 mb-5 mr-3 bg-white rounded"></div>
            <div class="col-3 shadow p-4 mb-5 bg-white rounded"></div>
            <div class="col-5 shadow p-4 mb-5 ml-3 bg-white rounded"></div>
        </div> -->
        <div class="row d-flex justify-content-center">
            <!-- <div class="col-3 shadow p-4 mb-5 mr-3 bg-white rounded"></div>
            <div class="col-3 shadow p-4 mb-5 bg-white rounded"></div>
            <div class="col-5 shadow p-4 mb-5 ml-3 bg-white rounded"><h5 class="text-info">Activity</h5></div> -->

            <div class="col-7 shadow p-4 mb-5 mr-3 ml-0 bg-white rounded">
                <h5 class="text-info">Bar</h5>
                <canvas id="myChart" width="100" height="55"></canvas>
            </div>
            <div class="col-4 shadow p-4 mb-5 ml-3 mr-0 bg-white rounded">
                <h5 class="text-info">Pie</h5>
                <canvas id="myChart2" width="" height=""></canvas>
            </div>
        </div>
    </div>
    <?php include 'sideMenuBar.php'; ?>
    <?php include 'footer.html'; ?>
    <!-- bar chart START -->
    <script>
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
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
                    'Red',
                    'Blue',
                    'Yellow'
                ],
                datasets: [{
                    label: 'My First Dataset',
                    data: [300, 50, 100],
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