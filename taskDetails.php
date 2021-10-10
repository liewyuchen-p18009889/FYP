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
    <!-- <link rel="stylesheet" href="/FYP/signInStyle.css"> -->
    <style>
        .swal-text {
            text-align: center;
        }

        /* .swal-button {
            background-color: #3AAFA9;
        } */

        .swal-footer {
            text-align: center;
        }
    </style>

    <title>UTask | Task Details</title>

    <script type="text/javascript">
    </script>
</head>

<body class="bg-light">
    <?php include 'header.php'; 

        function formatDate2($date){
            echo date('d/m/Y', strtotime($date));
        }
    ?>
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-md-6 col-xs-12 p-0">
                <h3 class="text-info">Task Details</h3>
            </div>
            <div class="col-md-6 col-xs-12 p-0 d-flex justify-content-end">
                <button class="btn btn-info mr-1" type="button" data-toggle="modal" data-target="#updTaskModal"><i
                        class="fas fa-edit" style="font-size: 20px;"></i>&nbsp;Edit Task
                </button>
                <button class="btn btn-danger ml-1" type="button" data-toggle="modal" data-target="#delTaskModal"><i
                        class="fas fa-trash" style="font-size: 20px;"></i>&nbsp;Delete Task
                </button>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="card shadow p-4 mb-5 ml-3 mr-3 bg-white rounded" style="min-height: 516px;">
            <?php
            $query7 = "SELECT * FROM tasks 
                        INNER JOIN users ON tasks.task_asignee=users.user_id 
                        WHERE task_id={$_GET['taskID']}";
            $runQuery7 = mysqli_query($dbc, $query7);

            if($runQuery7){
                foreach($runQuery7 as $row7){
        ?>
            <form role="form">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputTaskTitle">Title:</label>
                        <input type="text" class="form-control" name="viewTaskTitle" id="view_taskTitle"
                            aria-describedby="emailHelp" value="<?php echo $row7['task_title']; ?>" readonly>
                        <!-- <p class="m-0 p-2 text-danger addTaskTitleMsg"></p> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTaskStart">Start date:</label>
                        <input type="text" class="form-control" name="viewTaskStart" id="view_taskStart"
                            value="<?php echo formatDate2($row7['task_start']); ?>" readonly>
                        <!-- <p class="m-0 p-2 text-danger addTaskStartMsg"></p> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTaskEnd">End date:</label>
                        <input type="text" class="form-control" name="viewTaskEnd" id="view_taskEnd"
                            value="<?php echo formatDate2($row7['task_end']); ?>" readonly>
                        <!-- <p class="m-0 p-2 text-danger addTaskEndMsg"></p> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTaskAsignee">Asignee:</label>
                        <input type="text" class="form-control" name="viewTaskAsignee" id="view_taskAsignee"
                            value="<?php echo $row7['user_name']; ?>" readonly>
                        <!-- <p class="m-0 p-2 text-danger addTaskAsigneeMsg"></p> -->
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTaskStatus">Status:</label>
                        <input type="text" class="form-control" name="viewTaskStatus" id="view_taskStatus"
                            value="<?php echo $row7['task_status']; ?>" readonly>
                        <!-- <p class="m-0 p-2 text-danger addTaskStatusMsg"></p> -->
                    </div>
                    <div class="form-group col-md-12 m-0">
                        <label for="inputTaskDescrp">Description:</label>
                        <!-- <input type="text" class="form-control" name="addTaskDescrp" id="add_taskDescrp"
                                            aria-describedby="emailHelp" placeholder="Enter task description"> -->
                        <textarea class="form-control" name="viewTaskDescrp" id="view_taskDescrp" rows="10"
                            readonly><?php echo strip_tags($row7['task_description']); ?></textarea>
                        <!-- <p class="m-0 p-2 text-danger addTaskDescrpMsg"></p> -->
                    </div>
                </div>
            </form>
            <?php 
                }
            } 
        ?>
        </div>
    </div>
</body>

</html>