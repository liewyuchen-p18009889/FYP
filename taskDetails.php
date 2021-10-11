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
        function enableUpdTask() {
            $('input[type=text]').removeAttr('disabled');
            $('input[type=date]').removeAttr('disabled');
            $('#view_taskStatus').removeAttr('disabled');
            $('#view_taskAsignee').removeAttr('disabled');
            $('#view_taskDescrp').summernote('enable');
            $("#show_submitUpdTask").show();
            $("#show_cancelUpdTask").show();
        }

        function submitUpdTask(){
            var inputErrorArr = []; // to store error numbers of input field
            var projectID = $('#get_projectID').val();
            var taskID = $('#get_taskID').val();
            var taskTitle = $('#view_taskTitle').val();
            var taskStart = $('#view_taskStart').val();
            var taskEnd = $('#view_taskEnd').val();
            var taskAsignee = $('#view_taskAsignee').val();
            var taskStatus = $('#view_taskStatus').val();
            var taskDescrp = $('#view_taskDescrp').val();

            if (taskTitle.trim() == '') {
                $('.viewTaskTitleMsg').text('Title is required!');
                $('#view_taskTitle').focus();
                inputErrorArr.push(1);
            }
            if (taskStart.trim() == '') {
                $('.viewTaskStartMsg').text('Start date is required!');
                $('#view_taskStart').focus();
                inputErrorArr.push(1);
            }
            if (taskEnd.trim() == '') {
                $('.viewTaskEndMsg').text('End date is required!');
                $('#view_taskEnd').focus();
                inputErrorArr.push(1);
            }
            if (taskStart.trim() != '' && taskEnd.trim() != '') {
                if (Date.parse(taskEnd) < Date.parse(taskStart)) {
                    $('.viewTaskEndMsg').text('Invalid end date! Plasee try again!');
                    inputErrorArr.push(1);
                }
            }
            if (taskAsignee.trim() == '') {
                $('.viewTaskAsigneeMsg').text('Asignee is required!');
                $('#view_taskAsignee').focus();
                inputErrorArr.push(1);
            }
            if (taskStatus.trim() == '') {
                $('.viewTaskStatusMsg').text('Status is required!');
                $('#view_taskStatus').focus();
                inputErrorArr.push(1);
            }
            if (taskDescrp.trim() == '') {
                $('.viewTaskDescrpMsg').text('Description is required!');
                $('#view_taskDescrp').focus();
                inputErrorArr.push(1);
            }
            if (inputErrorArr.length == 0){
                $.ajax({
                    type: "POST",
                    url: "/FYP/updTaskData.php",
                    // data: "addTaskForm=1",
                    data: {
                        "updTaskForm": 1,
                        "viewTaskTitle": taskTitle,
                        "viewTaskStart": taskStart,
                        "viewTaskEnd": taskEnd,
                        "viewTaskAsignee": taskAsignee,
                        "viewTaskStatus": taskStatus,
                        "viewTaskDescrp": taskDescrp,
                        "projectID": projectID,
                        "taskID": taskID
                    },
                    // beforeSend: function () {
                    //     $('.btnAddTask').attr("disabled", "disabled");
                    //     $('.modal-body').css('opacity', '.5');
                    // },
                    success: function (response) {
                        console.log("swal upd response: " + response);
                        if (response == 'success') {
                            swal({
                                title: "Task updated successfully!",
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        } else if(response == 'fail') {
                            $(function () {
                                swal("Failed to update the task!", "", "warning");
                            });
                        }
                    }
                });
            }
        }

        function submitDelTask() {
            var projectID = $('#get_projectID').val();
            var taskID = $('#get_taskID').val();
            console.log("projectID: " + projectID);
            console.log("taskID: " + taskID);

            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data.",
                    icon: "error",
                    buttons: ["Cancel", "Delete"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "post",
                            url: "/FYP/delTaskData.php",
                            data: {
                                "del_set": 1,
                                "del_id": taskID,
                            },
                            success: function (response) {
                                console.log("swal del response: " + response);
                                if (response == 'success') {
                                    swal({
                                        title: "Task deleted successfully!",
                                        icon: "success",
                                    }).then((result) => {
                                        location.href = "/FYP/taskBoard.php?id=" + projectID;
                                    });
                                } else if (response == 'fail') {
                                    swal({
                                        title: "Failed to delete task!",
                                        icon: "warning",
                                    }).then((result) => {
                                        location.href = "/FYP/taskBoard.php?id=" + projectID;
                                    });
                                }
                            }
                        });
                    }
                });
        }
    </script>
</head>

<body class="bg-light">
    <?php include 'header.php'; 

        // check if the project's member so that can access to the project's task details START
        $query2 = "SELECT * FROM tasks WHERE task_project={$_GET['projectID']} AND task_id={$_GET['taskID']}";
        $runQuery2 = mysqli_query($dbc, $query2);
        $countQuery2 = mysqli_num_rows($runQuery2);

        if($countQuery2 == 0){
            echo '<script language="javascript">
                    alert("Invalid URL! No such project or task!");
                    window.location.href="/FYP/projectList.php";
                    </script>';
        }else{
            $query3 = "SELECT * FROM project_members WHERE 
                        user_id={$_SESSION['user_id']} AND project_id={$_GET['projectID']}";
            $runQuery3 = mysqli_query($dbc, $query3);
            $countQuery3 = mysqli_num_rows($runQuery3);

            if($countQuery3 == 0){
                echo '<script language="javascript">
                    alert("You are not a member of this project!");
                    window.location.href="/FYP/projectList.php";
                    </script>';
            }
        }
        // check if the project's member so that can access to the project's task details END

        function formatDate2($date){
            // echo date('d/m/Y', strtotime($date));
            echo date('Y-m-d', strtotime($date));
        }
    ?>
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-md-6 col-xs-12 p-0">
                <h3 class="text-info"><a href="/FYP/taskBoard.php?id=<?php echo $_GET['projectID']; ?>" title="Back to Task Board"><i class="fas fa-arrow-left text-info"></i></a> Task Details</h3>
            </div>
            <div class="col-md-6 col-xs-12 p-0 d-flex justify-content-end">
                <input type="hidden" class="getProjectID" id="get_projectID" value="<?php echo $_GET['projectID']; ?>">
                <input type="hidden" class="getTaskID" id="get_taskID" value="<?php echo $_GET['taskID']; ?>">
                <button class="btn btn-info mr-1" type="button" onclick="enableUpdTask()"><i class="fas fa-edit"
                        style="font-size: 20px;"></i>&nbsp;Edit Task
                </button>
                <button class="btn btn-danger ml-1 btnDelTask" type="button" onclick="submitDelTask()"><i
                        class="fas fa-trash-alt" style="font-size: 20px;"></i>&nbsp;Delete Task
                </button>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-4">
        <div class="card shadow p-4 mb-5 ml-3 mr-3 bg-white rounded" style="min-height: 516px;">
            <?php
            $query1 = "SELECT * FROM tasks 
                        INNER JOIN users ON tasks.task_asignee=users.user_id 
                        WHERE task_id={$_GET['taskID']}";
            $runQuery1 = mysqli_query($dbc, $query1);

            if($runQuery1){
                foreach($runQuery1 as $row1){
        ?>
            <form role="form">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputTaskTitle">Title:</label>
                        <input type="text" class="form-control" name="viewTaskTitle" id="view_taskTitle"
                            aria-describedby="emailHelp" value="<?php echo $row1['task_title']; ?>" disabled>
                        <p class="m-0 p-2 text-danger viewTaskTitleMsg"></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTaskStart">Start date:</label>
                        <input type="date" class="form-control" name="viewTaskStart" id="view_taskStart"
                            value="<?php echo formatDate2($row1['task_start']); ?>" disabled>
                        <p class="m-0 p-2 text-danger viewTaskStartMsg"></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTaskEnd">End date:</label>
                        <input type="date" class="form-control" name="viewTaskEnd" id="view_taskEnd"
                            value="<?php echo formatDate2($row1['task_end']); ?>" disabled>
                        <p class="m-0 p-2 text-danger viewTaskEndMsg"></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTaskAsignee">Asignee:</label>
                        <!-- <input type="text" class="form-control" name="viewTaskAsignee" id="view_taskAsignee"
                            value="<?php echo $row1['user_name']; ?>" readonly> -->

                        <select class="form-control" name="viewTaskAsignee" id="view_taskAsignee" disabled>
                            <?php
                                // $projectID = htmlspecialchars($_GET['id']); // get id from URL
                                $query4 = "SELECT * FROM project_members 
                                            INNER JOIN users ON project_members.user_id = users.user_id 
                                            WHERE project_id={$_GET['projectID']}";
                                $runQuery4 = mysqli_query($dbc, $query4);

                                if($runQuery4){
                                    foreach($runQuery4 as $row4){
                            ?>
                            <option value="<?php echo $row4['user_id'] ?>"
                                <?php if($row1['task_asignee']==$row4['user_id']) echo 'selected'; ?>>
                                <?php echo $row4['user_name'] ?>
                            </option>
                            <?php
                                        }
                                }
                            ?>
                        </select>
                        <p class="m-0 p-2 text-danger viewTaskAsigneeMsg"></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTaskStatus">Status:</label>
                        <!-- <input type="text" class="form-control" name="viewTaskStatus" id="view_taskStatus"
                            value="<?php echo $row1['task_status']; ?>" readonly> -->

                        <select class="form-control" name="viewTaskStatus" id="view_taskStatus" disabled>
                            <option value="To Do" <?php if($row1['task_status']=="To Do") echo 'selected'; ?>>To Do
                            </option>
                            <option value="In Progress"
                                <?php if($row1['task_status']=="In Progress") echo 'selected'; ?>>In Progress</option>
                            <option value="Test" <?php if($row1['task_status']=="Test") echo 'selected'; ?>>Test
                            </option>
                            <option value="Done" <?php if($row1['task_status']=="Done") echo 'selected'; ?>>Done
                            </option>
                        </select>
                        <p class="m-0 p-2 text-danger viewTaskStatusMsg"></p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputTaskDescrp">Description:</label>
                        <!-- <input type="text" class="form-control" name="addTaskDescrp" id="add_taskDescrp"
                                            aria-describedby="emailHelp" placeholder="Enter task description"> -->
                        <textarea class="form-control" name="viewTaskDescrp" id="view_taskDescrp"><?php echo strip_tags($row1['task_description']); ?></textarea>
                        <p class="m-0 p-2 text-danger viewTaskDescrpMsg"></p>
                    </div>
                    <div class="form-group col-md-12 m-0 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-1" id="show_cancelUpdTask" style="display:none" onclick="window.location.reload();">Cancel</button>
                        <button type="button" class="btn btn-info ml-1" id="show_submitUpdTask" style="display:none" onclick="submitUpdTask()">Save</button>
                    </div>
                </div>
            </form>
            <?php 
                }
            } 
        ?>
        </div>
    </div>
    <script type="text/javascript">
        $('#view_taskDescrp').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link']],
                ['misc', ['undo', 'redo']],
            ],
            height: 250
        });
        $('#view_taskDescrp').summernote('disable');
    </script>
</body>

</html>